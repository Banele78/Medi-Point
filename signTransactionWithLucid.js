const tx = await lucid.newTx()
  .payToAddress("addr_testa...", { lovelace: 5000000n })
  .payToAddress("addr_testb...", { lovelace: 5000000n })
  .complete();

const signedTx = await tx.sign().complete();