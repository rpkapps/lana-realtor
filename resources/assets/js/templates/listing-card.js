export default function(data = {}) {
    return `
        <a href="/listing/${data.vendor}/${data.id}" id="${data.id}" class="card" title="View listing. This opens a new window." target="_blank">
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
                        <p class="card-text">
                            <span class="card-item-info">
                                <strong>${data.bedrooms}</strong> bds
                            </span>    
                            <span class="card-item-info">
                                <strong>${data.bathrooms}</strong> ba
                            </span>    
                            <span class="card-item-info">
                                <strong>${data.property}</strong> sqft
                            </span>    
                        </p>
                    </div>
                </div>
        
            </div>
        </a>
    `;
}