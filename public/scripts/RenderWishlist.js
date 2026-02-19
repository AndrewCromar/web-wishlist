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

function MarkBought(itemId, amount) {
    const payload = { item_id: itemId };
    if (typeof amount !== 'undefined' && amount !== null) {
        payload.amount = amount;
    }
    return $.ajax({
        url: "../api/ENDPOINT_MarkItemBought.php",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(payload),
        dataType: "json"
    });
}

function MarkBoughtHandler(itemId, amount) {
    MarkBought(itemId, amount).done(function(resp) {
        if (resp.status === "OK") {
            location.reload();
        } else {
            alert("Failed to mark bought: " + (resp.error || resp.message));
        }
    }).fail(function() {
        alert("Network error marking item bought");
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
        if (item.bought) {
            if (!groupedItems.bought) groupedItems.bought = [];
            groupedItems.bought.push(item);
        } else {
            const gid = item.group_id || "ungrouped";
            if (!groupedItems[gid]) groupedItems[gid] = [];
            groupedItems[gid].push(item);
        }
    });

    const renderEntry = (gid) => {
        let name;
        if (gid === "ungrouped") {
            name = "Ungrouped";
        } else if (gid === "bought") {
            name = "Bought Items";
        } else {
            name = groupMap[gid] || `Group ${gid}`;
        }
        RenderGroup(name, gid, groupedItems[gid] || [], wishlistContainer);
        delete groupedItems[gid];
    };

    groups.forEach(group => {
        if (groupedItems[group.id]) {
            renderEntry(group.id);
        }
    });

    if (groupedItems.ungrouped) {
        renderEntry("ungrouped");
    }

    if (groupedItems.bought) {
        renderEntry("bought");
    }

    Object.keys(groupedItems).forEach(gid => renderEntry(gid));
}

function RenderGroup(name, groupId, groupItems, parentElement) {
    const wrapper = document.createElement("div");
    wrapper.className = "dropdown" + (groupId === "bought" ? "" : " open");

    const header = document.createElement("div");
    header.onclick = () => ToggleDropdown(wrapper);
    header.innerHTML = `
        <i class="fa-solid fa-caret-down"></i>
        <p>${name}</p>
    `;

    const content = document.createElement("div");
    content.className = "wishlist-container";

    if (groupItems.length === 0) {
        content.innerHTML = `<p style="color:var(--text-light); padding:10px;">No items in this group</p>`;
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

    if (item.bought) {
        wrapper.innerHTML = `
            <p>
              -&nbsp;
              <span><a href="${item.link || '#'}" target="_blank">${item.name}</a></span>&nbsp;
              <span><em>bought</em></span>
            </p>
        `;
    } else {
        let boughtLink = "";
        if (item.isFullyFunded) {
            boughtLink = `&nbsp;<a href="#" onclick="MarkBoughtHandler(${item.id}, ${item.calculatedFunds}); return false;" class="mark-bought">mark bought</a>`;
        }
        wrapper.innerHTML = `
            <p>
              -&nbsp;
              <span><a href="${item.link || '#'}">${item.name}</a></span>${boughtLink}&nbsp;
              <span>$${item.calculatedFunds} / $${item.price} (${item.percentFilled}%)</span>
            </p>
            <div class="progress-container" style="background: var(--background); border: solid var(--border) 2px; overflow: hidden;">
                <div class="progress-bar" style="
                    width: ${item.percentFilled}%;
                    height: 8px; 
                    background: ${item.isFullyFunded ? 'var(--success)' : 'var(--background-dark)'};
                    transition: width 0.5s ease;
                "></div>
            </div>
        `;
    }

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
        const activeItems = items.filter(i => !i.bought);
        const scores = activeItems.map(CalculateItemScore);
        const prices = activeItems.map(i => parseFloat(i.price) || 0);
        const n = activeItems.length;
        const allocations = new Array(n).fill(0);
        let remainingFunds = totalFunds;
        const remainingSet = new Set();
        for (let i = 0; i < n; i++) {
            if (prices[i] === 0) continue;
            remainingSet.add(i);
        }
        while (remainingFunds > 0 && remainingSet.size > 0) {
            let totalScore = 0;
            remainingSet.forEach(i => { totalScore += scores[i]; });
            if (totalScore === 0) break;
            let allocatedThisRound = 0;
            const toRemove = [];
            remainingSet.forEach(i => {
                const share = scores[i] / totalScore;
                let desired = remainingFunds * share;
                const cap = prices[i] - allocations[i];
                if (desired >= cap) {
                    allocations[i] += cap;
                    allocatedThisRound += cap;
                    toRemove.push(i);
                } else {
                    allocations[i] += desired;
                    allocatedThisRound += desired;
                }
            });
            toRemove.forEach(i => remainingSet.delete(i));
            if (allocatedThisRound <= 0) break;
            remainingFunds -= allocatedThisRound;
        }
        const calculatedItems = items.map(item => {
            if (item.bought) {
                return {
                    ...item,
                    calculatedFunds: '0.00',
                    percentFilled: 100,
                    isFullyFunded: true
                };
            }
            const idx = activeItems.indexOf(item);
            let alloc = 0;
            if (idx !== -1) alloc = allocations[idx];
            const price = parseFloat(item.price) || 0;
            const percent = price > 0 ? Math.min((alloc / price) * 100, 100).toFixed(1) : 0;
            return {
                ...item,
                calculatedFunds: alloc.toFixed(2),
                percentFilled: percent,
                isFullyFunded: alloc >= price
            };
        });
        RenderData(calculatedItems, groups);
    } catch (error) {
        console.error("An error occurred:", error);
    }
}

document.addEventListener("DOMContentLoaded", function () {
	RenderWishlist();
});
