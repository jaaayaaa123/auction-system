const ws = new WebSocket('ws://localhost:8080');
var conn = new WebSocket('ws://localhost:8080');

ws.onopen = () => {
    console.log('Connected to the WebSocket server');
};

ws.onmessage = (event) => {
    const data = JSON.parse(event.data);
    const bidList = document.getElementById('bid-list');
    const newBid = document.createElement('li');
    newBid.textContent = `${data.username} placed a bid of $${data.amount}`;
    bidList.prepend(newBid);
};

function sendBid(product_id, username, amount) {
    const message = JSON.stringify({
        product_id: product_id,
        username: username,
        amount: amount
    });
    ws.send(message);
}
