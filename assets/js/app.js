
function addMessage(message, status) {
    var content = '<div class="' + (status === 'failed' ? 'Error' : 'Success') + '">';
    content += message + '</div>';
    $(".Body").append(content);
    console.trace();
}

function handleError(message) {
    addMessage('<h2>Error:</h2>' + message, 'failed');
}