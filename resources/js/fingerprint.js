import FingerprintJS from '@fingerprintjs/fingerprintjs';

document.addEventListener('DOMContentLoaded', async () => {
    const fp = await FingerprintJS.load();
    const result = await fp.get();
    const fingerprint = result.visitorId;

    document.querySelectorAll('input[name="fingerprint"]').forEach(input => {
      input.value = fingerprint;
    });
  });