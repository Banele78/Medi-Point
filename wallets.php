<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
   
</head>
<body>
    <div class="form">
        <h1 id="status">
            Status: Not Connected
        </h1>
      
        <button id="button">
            Connect Wallet
        </button>

        <div>
            <label for="destinationAddress">Destination Address:</label>
            <input type="text" id="destinationAddress" placeholder="Enter destination address">
        </div>

        <button id="sendButton" >
            Send ADA
        </button>
    </div>

    <script type="module">
     import { Lucid,Blockfrost} from "https://unpkg.com/lucid-cardano/web/mod.js"

     
        const button = document.getElementById('button');
        const sendButton = document.getElementById('sendButton');
        const destinationAddressInput = document.getElementById('destinationAddress');

        let lucid;

        async function connectWallet() {
            if (typeof window.cardano == 'undefined' || typeof window.cardano.nami == 'undefined') {
                return;
            }

            try {
                const api = await window.cardano.nami.enable();
                lucid = await Lucid.new();
                lucid.selectWallet(api);

                const bech32Address = await lucid.wallet.address();
                const balanceHex = await lucid.wallet.getUtxos();
                


                console.log("Balance Hex:", balanceHex); // Log the balanceHex array for debugging

                if (balanceHex.length > 0) {
                    const firstUtxo = balanceHex[0];
                    console.log("First Utxo:", firstUtxo); // Log the first Utxo object for debugging

                    // Log keys of the firstUtxo object
                    console.log("Utxo Keys:", Object.keys(firstUtxo));

                    // Log the assets object
                    console.log("Assets:", firstUtxo.assets);

                    // Use the correct key 'lovelace' representing the amount within the assets object
                    const amountProperty = firstUtxo.assets ? firstUtxo.assets.lovelace : null;

                    if (amountProperty) {
                        const balanceLovelace = BigInt(amountProperty);
                        const lovelacePerAda = BigInt(1_000_000);
                        const balanceADA = balanceLovelace / lovelacePerAda;

                       


                        const status = document.getElementById('status');
                        status.innerHTML = "Status: Connected"
                        button.innerHTML = `Balance:${balanceADA} ADA`;
                        sendButton.disabled = false; // Enable the send button after connecting
                    } else {
                        const status = document.getElementById('status');
                        status.innerHTML = "Error: Utxo does not have a property representing the amount.";
                    }
                } else {
                    const status = document.getElementById('status');
                    status.innerHTML = "Error: No Utxo found in the balance information.";
                }
            } catch (error) {
                console.error("Error connecting to wallet:", error);
                const status = document.getElementById('status');
                status.innerHTML = "Error connecting to wallet.";
            }
        }
       
        async function sendTransaction() {

         

const lucid = await Lucid.new(
    new Blockfrost(
  "https://cardano-preprod.blockfrost.io/api/v0", // Adjust this endpoint
  "preprodGAZEMdUuCiAHUwvEDEArXvns7bXu3rpX"
),

  "Preprod",
);
  const destinationAddress = destinationAddressInput.value.trim();

  if (!destinationAddress) {
    alert('Please enter a valid destination address.');
    return;
  }

  try {

    const api = await window.cardano.nami.enable();
               
                lucid.selectWallet(api);

                const bech32Address = await lucid.wallet.address();

const tx = await lucid.newTx()
  .payToAddress(destinationAddress, { lovelace: 500000n })
  
  .complete();

const signedTx = await tx.sign().complete();
const txHash = await signedTx.submit();

console.log('Transaction submission result:', txHash);
    const status = document.getElementById('status');
    status.innerHTML = 'Status: Transaction Sent';

  } catch (error) {
    console.error('Error sending transaction:', error);
    const status = document.getElementById('status');
    if (error.response && error.response.status === 404) {
        status.innerHTML = 'Error: Address not found or no UTXOs available.';
    } else if (error.response && error.response.status === 400) {
        status.innerHTML = 'Error: Bad request or insufficient funds.';
    } else {
        status.innerHTML = 'Error sending transaction. Please check your wallet and try again.';
    }
}
}

        button.onclick = connectWallet;
        sendButton.onclick = sendTransaction;

    </script>
</body>
</html>
