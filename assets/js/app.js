
function addMessage(message, status) {
    var content = '<div class="' + (status === 'failed' ? 'Error' : 'Success') + '">';
    if(status === 'failed') {
        content+= '<h2>Error:</h2>';
    }
    content += message + '</div>';
    $(".Body").append(content);
    console.trace();
}

function handleError(message) {
    addMessage(message, 'failed');
}
