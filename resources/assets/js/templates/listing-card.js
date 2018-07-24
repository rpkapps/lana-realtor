/**
 * Create Html for info item
 * @param value
 * @param type
 * @returns {string}
 */
function createInfoItemHtml(value, type) {
    return `
        <span class="card-item-info">
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
        <a href="/listing/l/${data.id}" id="${data.id}" class="card" title="View listing">
            <div class="card-background b-lazy" data-src="${data.photo}">
                <span class="loader"></span>
            </div>
            <div class="card-body">
                <div class="row card-body-row">
                    <div class="col-7">
                        <h4 class="card-title text-primary">${data.title}</h4>
                    </div>
                    <div class="col-5">
                        <h4 class="card-title">$${data.price}</h4>
                    </div>
                </div>
        
                <div class="row card-body-row">
                    <div class="col-7 card-col-reverse">
                        <p class="card-text">${data.address}</p>
                    </div>
                    <div class="col-5 card-col-reverse">
                        <p class="card-text">${infoItemsHtml}</p>
                    </div>
                </div>
        
            </div>
        </a>
    `;
}