// I would use not arrow functions to have a consistence in the code, but for this test I use either functions and arrow functions when the can be used.

window.onbeforeunload = function(e) {
    sendRequest('clearSession', 'GET', () => {})
}

sendMessage = (e) => {
    if(e.charCode == 13)
    {
        const sendButton = document.getElementById('send-message')
        const text = sendButton.value

        // Reset button text
        sendButton.value = ''

        if(text != '') {
            sendRequest('chat/message', 'POST', appendMessage, [
                ['text', text ],
                ['type', 'sent']
            ])
        }

    }
}

addFriend = () => {
    const addFriendButton = document.getElementById('add-friend')
    addFriendButton.classList.toggle('active')

    document.body.classList.toggle('active')
}

sendRequest = (url, type, callback, params = []) => {
    let request = new XMLHttpRequest()
    request.callback = callback
    request.onload = requestSuccess
    request.onerror = requestError
    request.open(type, url, true)

    let data = null;
    if(params.length > 0 && type == 'POST')
    {
        data = new FormData()
        for (var i = 0; i < params.length; i++) {
            data.append(params[i][0], params[i][1])
        }
    }

    request.send(data);
}

function requestSuccess() {
    this.callback.apply(this);
}

function requestError() {
    console.error(this.statusText)
}

function appendMessage()
{
    const chatContainer = document.getElementById('chat-container')
    chatContainer.insertAdjacentHTML('beforeend', this.responseText)

    chatContainer.scrollTop = chatContainer.scrollHeight
}
