export default function(data = {}) {
    return `
        <a href="/listing-item/${data.id}" id="${data.id}" class="card">
            <div class="card-background b-lazy" data-src="${data.photo}">
                <span class="loader"></span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-7 pr-1">
                        <h4 class="card-title text-primary">${data.title}</h4>
                    </div>
                    <div class="col-5 pl-1 text-right">
                        <h4 class="card-title">$${data.price}</h4>
                    </div>
                </div>
        
                <div class="row">
                    <div class="col-7 pr-1">
                        <p class="card-text">${data.address}</p>
                    </div>
                    <div class="col-5 pl-1 text-right">
                        <p class="card-text">
                            <strong>${data.bedrooms}</strong> bds
                            <strong>${data.bathrooms}</strong> ba
                            <strong>${data.property}</strong> sqft
                        </p>
                    </div>
                </div>
        
            </div>
        </a>
    `;
}