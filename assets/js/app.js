
function addMessage(message, status) {
    var content = '<div class="' + (status === 'failed' ? 'Error' : 'Success') + '">';
    content += message + '</div>';
    $(".Page").append(content);
    console.trace();
}

function handleError(message) {
    addMessage('<h2>Error:</h2>' + message, 'failed');
}