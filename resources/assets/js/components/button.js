export function addLoader($btn) {
    $btn.prop('disabled', true);
    $btn.prepend(`<span class="btn-loader"></span>`);
}

export function removeLoader($btn) {
    $btn.prop('disabled', false);
    $btn.children('.btn-loader').remove();
}

export default {
    addLoader: addLoader,
    removeLoader: removeLoader
}