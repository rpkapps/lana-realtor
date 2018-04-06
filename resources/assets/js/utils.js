/**
 * Format number to contain commas
 * @param number
 * @returns {string}
 */
function formatNumber(number = 0) {
    return parseFloat(number) ? parseFloat(number).toLocaleString('en') : '';
}

export default {
    formatNumber: formatNumber,
};