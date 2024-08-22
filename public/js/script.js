document.addEventListener("DOMContentLoaded", function() {
    function loadAuctions() {
        fetch("load_auctions.php")
            .then(response => response.json())
            .then(data => {
                data.forEach(auction => {
                    const auctionDiv = document.querySelector(`.auction-item[data-id='${auction.id}']`);
                    if (auctionDiv) {
                        auctionDiv.querySelector('.current-bid').textContent = auction.current_bid;
                        if (auction.closed) {
                            auctionDiv.querySelector('.bid-button').disabled = true;
                            auctionDiv.querySelector('.closed').textContent = 'Auction Closed';
                        }
                    }
                });
            })
            .catch(error => console.error("Error loading auctions:", error));
    }

    window.placeBid = function(auctionId) {
        fetch("place_bid.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ auction_id: auctionId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Bid placed successfully!");
                loadAuctions(); 
            } else {
                alert("Error placing bid.");
            }
        })
        .catch(error => console.error("Error placing bid:", error));
    }

    loadAuctions();
    setInterval(loadAuctions, 5000);
});
