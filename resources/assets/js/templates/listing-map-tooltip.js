/**
 * Create Html for info item
 * @param value
 * @param type
 * @returns {string}
 */
function createInfoItemHtml(value, type) {
    return `
        <span class="map-tooltip-info">
            <strong>${value}</strong> ${type}
        </span>`;
}


export default function(data = {}) {
    var infoItemsHtml = '';

    if(data.bedrooms) {
        infoItemsHtml += createInfoItemHtml(data.bedrooms, 'bds');
    }

    if(data.bathrooms) {
        infoItemsHtml += createInfoItemHtml(data.bathrooms, 'ba');
    }

    if(data.residenceSqft) {
        infoItemsHtml += createInfoItemHtml(data.residenceSqft, 'sqft');
    }

    if(data.acres) {
        infoItemsHtml += createInfoItemHtml(data.acres, 'ac');
    }

    return `
        <div class="map-tooltip-img" style="background-image: url(${data.thumbnail})"></div>
        <div class="map-tooltip-content">
            <h4 class="map-tooltip-title">$${data.price}</h4>
            <p>${infoItemsHtml}</p>
            <p class="map-tooltip-footer">${data.address}</p>
        </div>
    `;
}