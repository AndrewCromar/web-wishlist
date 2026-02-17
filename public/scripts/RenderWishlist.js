function GetAllItemData() {
    return $.ajax({
        url: "../api/ENDPOINT_GetUserItems.php",
        type: "POST",
        dataType: "json"
    });
}

function GetNetFunds() {
    return $.ajax({
        url: "../api/ENDPOINT_GetTotalFunds.php",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({}),
        dataType: "json"
    });
}

function CalculateItemScore(item) {
    const now = Date.now();
    const createdAt = new Date(item.created_at).getTime();
    
    const ageInDays = (now - createdAt) / (1000 * 60 * 60 * 24);
    
    return item.weight * (ageInDays + 0.1);
}

function RenderData(items, groups) {
    const wishlistContainer = document.getElementsByClassName("wishlist-groups")[0];
    wishlistContainer.innerHTML = "";

    const groupMap = {};
    groups.forEach(g => groupMap[g.id] = g.name);

    const groupedItems = {};
    items.forEach(item => {
        const gid = item.group_id || "ungrouped";
        if (!groupedItems[gid]) groupedItems[gid] = [];
        groupedItems[gid].push(item);
    });

    Object.keys(groupedItems).forEach(gid => {
        const name = gid === "ungrouped" ? "Ungrouped" : (groupMap[gid] || `Group ${gid}`);
        RenderGroup(name, gid, groupedItems[gid], wishlistContainer);
    });

    groups.forEach(group => {
        if (!groupedItems[group.id]) {
            RenderGroup(group.name, group.id, [], wishlistContainer);
        }
    });
}

function RenderGroup(name, groupId, groupItems, parentElement) {
    const wrapper = document.createElement("div");
    wrapper.className = "dropdown open";

    const header = document.createElement("div");
    header.onclick = () => ToggleDropdown(wrapper);
    header.innerHTML = `
        <i class="fa-solid fa-caret-down"></i>
        <p>${name} <span style="color:var(--text-color-muted); font-size:smaller;">#${groupId}</span></p>
    `;

    const content = document.createElement("div");
    content.className = "wishlist-container";

    if (groupItems.length === 0) {
        content.innerHTML = `<p style="color:var(--text-color-muted); padding:10px;">No items in this group</p>`;
    } else {
        groupItems.forEach(item => {
            const itemElement = RenderItem(item);
            content.appendChild(itemElement);
        });
    }

    wrapper.appendChild(header);
    wrapper.appendChild(content);
    parentElement.appendChild(wrapper);
}

function RenderItem(item) {
    const wrapper = document.createElement("div");
    wrapper.className = "wishlist-item-wrapper";

    wrapper.innerHTML = `
        <p>
          -&nbsp;
          <span><a href="${item.link || '#'}">${item.name}</a></span>&nbsp;
          <span>$${item.calculatedFunds} / $${item.price} (${item.percentFilled}%)</span>&nbsp;
          <span>#${item.id}</span>
        </p>
        <div class="progress-container" style="background: rgba(0,0,0,0.1); border-radius: 4px; overflow: hidden;">
            <div class="progress-bar" style="
                width: ${item.percentFilled}%; 
                height: 8px; 
                background: ${item.isFullyFunded ? 'var(--success-color, green)' : 'var(--primary-color, blue)'};
                transition: width 0.5s ease;
            "></div>
        </div>
    `;

    return wrapper;
}

async function RenderWishlist() {
    try {
        const itemResponse = await GetAllItemData();
        const fundsResponse = await GetNetFunds();

        if (itemResponse.status !== "OK" || fundsResponse.status !== "OK") {
            console.error("Data fetch failed");
            return;
        }

        const { items, groups } = itemResponse.data;
        const totalFunds = fundsResponse.data;

        const scores = items.map(item => CalculateItemScore(item));
        const totalScore = scores.reduce((a, b) => a + b, 0);

        const calculatedItems = items.map((item, index) => {
            const share = totalScore > 0 ? (scores[index] / totalScore) : 0;
            const itemFunds = totalFunds * share;
            const itemPrice = parseFloat(item.price) || 0;
            
            return {
                ...item,
                calculatedFunds: itemFunds.toFixed(2),
                percentFilled: itemPrice > 0 ? Math.min((itemFunds / itemPrice) * 100, 100).toFixed(1) : 0,
                isFullyFunded: itemFunds >= itemPrice
            };
        });

        RenderData(calculatedItems, groups);
    } catch (error) {
        console.error("An error occurred:", error);
    }
}