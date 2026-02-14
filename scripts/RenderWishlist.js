function RenderWishlist() {
  $.ajax({
    url: "../backend/endpoints/ENDPOINT_GetUserItems.php",
    type: "POST",
    dataType: "json",
    success: function (response) {
      if (response.status === "OK") {
        const wishlistContainer =
          document.getElementsByClassName("wishlist-groups")[0];
        wishlistContainer.innerHTML = null;

        const { items, groups } = response.data;

        const groupMap = {};
        groups.forEach((group) => {
          groupMap[group.id] = group.name;
        });

        const groupedItems = {};
        items.forEach((item) => {
          const groupId = item.group_id || "";
          if (!groupedItems[groupId]) {
            groupedItems[groupId] = [];
          }
          groupedItems[groupId].push(item);
        });

        Object.keys(groupedItems).forEach((groupId) => {
          const groupName =
            groupId === "ungrouped" ? "Ungrouped" : groupMap[groupId];
          wishlistContainer.appendChild(
            GenerateWishlistGroup(groupName, groupedItems[groupId], groupId),
          );
        });

        groups.forEach((group) => {
          if (!groupedItems[group.id]) {
            wishlistContainer.appendChild(
              GenerateEmptyWishlistGroup(group.name, group.id),
            );
          }
        });
      } else {
        alert(response.status + " " + response.error);
      }
    },
  });
}

function GenerateWishlistGroup(name, items, groupId) {
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
  items.forEach((item) => {
    content.appendChild(
      GenerateWishlistItem(
        item.name,
        item.link,
        item.price,
        item.money_saved,
        item.id,
      ),
    );
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
      <span><a href="${url}">${name}</a></span>&nbsp;
      <span>$${money_saved} / $${price} (${percent}%)</span>&nbsp;
      <span>#${id}</span>
    </p>
    <div><div style="width:${percent}%;"></div></div>
  `;

  return wrapper;
}

RenderWishlist();
