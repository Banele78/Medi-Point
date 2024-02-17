<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardano Transaction</title>
</head>
<body>
    <h1 id="status">Status: Not Connected</h1>
    <button id="connectButton" style="width:200px;height:30px;">Connect Wallet</button>
    <input type="text" id="recipientAddress" placeholder="Recipient Address" style="width:300px;height:30px;">
    <input type="text" id="amount" placeholder="Amount (ADA)" style="width:200px;height:30px;">
    <button id="sendButton" style="width:200px;height:30px;display:none;">Send ADA</button>

    <script type="module">
        import { Address, Transaction, CSL } from "./node_modules/@emurgo/cardano-serialization-lib-asmjs/cardano_serialization_lib.js";

        var status = document.getElementById("status");
        var connectButton = document.getElementById("connectButton");
        var recipientAddressInput = document.getElementById("recipientAddress");
        var amountInput = document.getElementById("amount");
        var sendButton = document.getElementById("sendButton");

        var senderAddress; // Store sender address after connection

        async function connectWallet() {
            if (typeof window.cardano === 'undefined' || typeof window.cardano.nami === 'undefined')
                return;

            const api = await window.cardano.nami.enable();
            const addy = await api.getUsedAddresses();
            
            senderAddress = Address.from_hex(addy[0]).to_bech32();
            status.innerHTML = "Address: " + senderAddress;
            sendButton.style.display = "block";
        }

        async function sendTransaction() {
            if (typeof window.cardano === 'undefined' || typeof window.cardano.nami === 'undefined')
                return;

            const recipientAddress = recipientAddressInput.value.trim();
            const amount = amountInput.value.trim();

            if (!recipientAddress || !amount) {
                alert("Please enter both recipient address and amount.");
                return;
            }

            const api = await window.cardano.nami.enable();
            const utxos = await api.getUTXOs(senderAddress);

            const inputs = utxos.map(utxo => Transaction.Input.from_json(utxo));

            const output = Transaction.Output.new(
                Address.from_bech32(recipientAddress),
                CSL.Value.new(CSL.BigNum.from_str(amount))
            );

            const outputs = [output];

            const fee = CSL.BigNum.from_str("1000000"); // Replace with actual fee calculation

            const tx = Transaction.new(
                CSL.BigNum.from_str("1"), // Replace with actual transaction number
                inputs,
                outputs,
                fee,
                CSL.BigNum.from_str("0"), // Replace with actual TTL (time to live)
            );

            // Sign the transaction
            const privateKey = "your_private_key"; // Replace with the sender's private key
            const signedTx = api.signTransaction(tx, privateKey);

            // Broadcast the transaction
            const txHash = await api.submitTx(signedTx);

            status.innerHTML = "Transaction sent successfully. TxHash: " + txHash;
        }

        connectButton.onclick = connectWallet;
        sendButton.onclick = sendTransaction;
    </script>
</body>
</html>
