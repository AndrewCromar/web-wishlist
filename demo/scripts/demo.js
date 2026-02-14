const Demo = (function () {
  let nextItemId = 1;
  let nextGroupId = 1;

  const groups = [];
  const items = [];

  function showMessage(msg) {
    const el = document.getElementById('demo-status');
    if (el) {
      el.textContent = msg;
      setTimeout(() => { if (el.textContent === msg) el.textContent = ''; }, 4000);
    } else {
      console.log(msg);
    }
  }

  function seed() {
    groups.push({ id: nextGroupId++, name: "Gadgets" });
    groups.push({ id: nextGroupId++, name: "Books" });

    items.push({
      id: nextItemId++,
      name: "Mechanical Keyboard",
      link: "https://example.com/keyboard",
      price: 120,
      money_saved: 20,
      group_id: 1,
    });

    items.push({
      id: nextItemId++,
      name: "Clean Code (Book)",
      link: "https://example.com/cleancode",
      price: 35,
      money_saved: 5,
      group_id: 2,
    });

    items.push({
      id: nextItemId++,
      name: "Fancy Mug",
      link: "https://example.com/mug",
      price: 15,
      money_saved: 0,
      group_id: null,
    });
  }

  function RenderWishlist() {
    const wishlistContainer = document.getElementsByClassName("wishlist-groups")[0];
    wishlistContainer.innerHTML = null;

    const groupMap = {};
    groups.forEach((group) => {
      groupMap[group.id] = group.name;
    });

    const groupedItems = {};
    items.forEach((item) => {
      const groupId = item.group_id || "ungrouped";
      if (!groupedItems[groupId]) {
        groupedItems[groupId] = [];
      }
      groupedItems[groupId].push(item);
    });

    Object.keys(groupedItems).forEach((groupId) => {
      const groupName = groupId === "ungrouped" ? "Ungrouped" : groupMap[groupId];
      wishlistContainer.appendChild(GenerateWishlistGroup(groupName, groupedItems[groupId], groupId));
    });

    groups.forEach((group) => {
      if (!groupedItems[group.id]) {
        wishlistContainer.appendChild(GenerateEmptyWishlistGroup(group.name, group.id));
      }
    });
  }

  function GenerateWishlistGroup(name, itemsArr, groupId) {
    const wrapper = document.createElement("div");
    wrapper.className = "dropdown open";

    const header = document.createElement("div");
    header.onclick = function () {
      ToggleDropdown(wrapper);
    };

    const caretIcon = document.createElement("i");
    caretIcon.className = "fa-solid fa-caret-down";

    const title = document.createElement("p");
    title.appendChild(document.createTextNode(name));

    const idSpan = document.createElement("span");
    idSpan.style.color = "var(--text-color-muted)";
    idSpan.style.fontSize = "smaller";
    idSpan.textContent = `#${groupId}`;

    title.appendChild(document.createTextNode("\u00A0"));
    title.appendChild(idSpan);

    header.appendChild(caretIcon);
    header.appendChild(title);

    const content = document.createElement("div");
    content.className = "wishlist-container";
    itemsArr.forEach((item) => {
      content.appendChild(GenerateWishlistItem(item.name, item.link, item.price, item.money_saved, item.id));
    });

    wrapper.appendChild(header);
    wrapper.appendChild(content);

    return wrapper;
  }

  function GenerateEmptyWishlistGroup(name, groupId) {
    const wrapper = document.createElement("div");
    wrapper.className = "dropdown open";

    const header = document.createElement("div");
    header.onclick = function () {
      ToggleDropdown(wrapper);
    };

    const caretIcon = document.createElement("i");
    caretIcon.className = "fa-solid fa-caret-down";

    const title = document.createElement("p");
    title.appendChild(document.createTextNode(name));

    const idSpan = document.createElement("span");
    idSpan.style.color = "var(--text-color-muted)";
    idSpan.style.fontSize = "smaller";
    idSpan.textContent = `#${groupId}`;

    title.appendChild(document.createTextNode("\u00A0"));
    title.appendChild(idSpan);

    header.appendChild(caretIcon);
    header.appendChild(title);

    const content = document.createElement("div");
    const emptyMessage = document.createElement("p");
    emptyMessage.textContent = "No items in this group";
    emptyMessage.style.color = "var(--text-color-muted)";
    emptyMessage.style.padding = "10px";
    content.appendChild(emptyMessage);

    wrapper.appendChild(header);
    wrapper.appendChild(content);

    return wrapper;
  }

  function GenerateWishlistItem(name, url, price, money_saved, id) {
    const percent = Math.min(price > 0 ? Math.round((money_saved / price) * 100) : 0, 100);

    const wrapper = document.createElement("div");

    wrapper.innerHTML = `
      <p>
        -&nbsp;
        <span><a href="${url}" target="_blank" rel="noopener noreferrer">${name}</a></span>&nbsp;
        <span>$${money_saved} / $${price} (${percent}%)</span>&nbsp;
        <span>#${id}</span>
      </p>
      <div><div style="width:${percent}%;"></div></div>
    `;

    return wrapper;
  }

  function AddItem(name, link, price) {
    items.push({ id: nextItemId++, name, link, price: Number(price), money_saved: 0, group_id: "ungrouped" });
    RenderWishlist();
    showMessage("Item added (demo only)");
  }

  function EditItem(id, name, link, price, groupId) {
    const it = items.find((x) => x.id === Number(id));
    if (!it) {
      showMessage("Item not found");
      return;
    }
    it.name = name;
    it.link = link;
    it.price = Number(price);
    it.group_id = Number(groupId) || "ungrouped";
    RenderWishlist();
    showMessage("Item edited (demo only)");
  }

  function RemoveItem(id) {
    const idx = items.findIndex((x) => x.id === Number(id));
    if (idx === -1) {
      showMessage("Item not found");
      return;
    }
    items.splice(idx, 1);
    RenderWishlist();
    showMessage("Item removed (demo only)");
  }

  function RemoveBoughtItems() {
    for (let i = items.length - 1; i >= 0; i--) {
      if (items[i].price > 0 && items[i].money_saved >= items[i].price) {
        items.splice(i, 1);
      }
    }
    RenderWishlist();
    showMessage("Bought items removed (demo only)");
  }

  function AddGroup(name) {
    groups.push({ id: nextGroupId++, name });
    RenderWishlist();
    showMessage("Group added (demo only)");
  }

  function EditGroup(id, name) {
    const g = groups.find((x) => x.id === Number(id));
    if (!g) {
      showMessage("Group not found");
      return;
    }
    g.name = name;
    RenderWishlist();
    showMessage("Group edited (demo only)");
  }

  function RemoveGroup(id) {
    const idx = groups.findIndex((x) => x.id === Number(id));
    if (idx === -1) {
      showMessage("Group not found");
      return;
    }
    // move items in that group to ungrouped
    items.forEach((it) => {
      if (it.group_id === Number(id)) it.group_id = "ungrouped";
    });
    groups.splice(idx, 1);
    RenderWishlist();
    showMessage("Group removed (demo only)");
  }

  function RemoveUnusedGroups() {
    const used = new Set(items.map((it) => it.group_id).filter((g) => g !== "ungrouped"));
    for (let i = groups.length - 1; i >= 0; i--) {
      if (!used.has(groups[i].id)) groups.splice(i, 1);
    }
    RenderWishlist();
    showMessage("Unused groups removed (demo only)");
  }

  function AddFunding(amount) {
    let best = null;
    let lowestPercent = 101;
    items.forEach((it) => {
      const p = it.price > 0 ? Math.round((it.money_saved / it.price) * 100) : 100;
      if (p < lowestPercent) {
        lowestPercent = p;
        best = it;
      }
    });
    if (!best) {
      showMessage("No items to add funding to (demo)");
      return;
    }
    best.money_saved += Number(amount);
    RenderWishlist();
    showMessage(`$${amount} added to \"${best.name}\" (demo only)`);
  }

  function bind() {
    document.getElementById("addItemButton").onclick = function () {
      const name = document.getElementById("add_name").value;
      const link = document.getElementById("add_link").value;
      const price = document.getElementById("add_price").value;
      if (!name || !link || !price) {
        showMessage("Please fill required fields");
        return;
      }
      AddItem(name, link, price);
      document.getElementById("addItemForm").reset();
    };

    document.getElementById("editItemButton").onclick = function () {
      const id = document.getElementById("edit_id").value;
      const name = document.getElementById("edit_name").value;
      const link = document.getElementById("edit_link").value;
      const price = document.getElementById("edit_price").value;
      const group = document.getElementById("edit_group").value;
      if (!id || !name || !link || !price) {
        showMessage("Please fill required fields");
        return;
      }
      EditItem(id, name, link, price, group);
      document.getElementById("editItemForm").reset();
    };

    document.getElementById("removeItemButton").onclick = function () {
      const id = document.getElementById("remove_id").value;
      if (!id) { showMessage("Please supply Item ID"); return; }
      RemoveItem(id);
      document.getElementById("removeItemForm").reset();
    };

    document.getElementById("removeBoughtButton").onclick = function () {
      RemoveBoughtItems();
    };

    document.getElementById("addGroupButton").onclick = function () {
      const name = document.getElementById("add_group_name").value;
      if (!name) { showMessage("Please supply group name"); return; }
      AddGroup(name);
      document.getElementById("addGroupForm").reset();
    };

    document.getElementById("editGroupButton").onclick = function () {
      const id = document.getElementById("edit_group_id").value;
      const name = document.getElementById("edit_group_name").value;
      if (!id || !name) { showMessage("Please fill required fields"); return; }
      EditGroup(id, name);
      document.getElementById("editGroupForm").reset();
    };

    document.getElementById("removeGroupButton").onclick = function () {
      const id = document.getElementById("remove_group_id").value;
      if (!id) { showMessage("Please supply Group ID"); return; }
      RemoveGroup(id);
      document.getElementById("removeGroupForm").reset();
    };

    document.getElementById("removeUnusedGroupsButton").onclick = function (e) {
      e.preventDefault();
      RemoveUnusedGroups();
    };

    document.getElementById("addFundingButton").onclick = function () {
      const amount = document.getElementById("add_funding_amount").value;
      if (!amount) { showMessage("Please supply an amount"); return; }
      AddFunding(amount);
      document.getElementById("addFundingForm").reset();
    };
  }

  function init() {
    seed();
    bind();
    RenderWishlist();
  }

  return { init };
})();

$(document).ready(function () {
  Demo.init();
});