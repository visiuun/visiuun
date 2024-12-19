 function copyCode(button) {
    const codeBlock = button.previousElementSibling;
    
    // Check if Clipboard API is supported
    if (navigator.clipboard && navigator.clipboard.writeText) {
        // Use textContent to get the full content of the code block
        navigator.clipboard.writeText(codeBlock.textContent)
            .then(() => {
                button.textContent = 'Copied!';
                setTimeout(() => {
                    button.textContent = 'Copy Text';
                }, 2000);
            })
            .catch(err => {
                console.error('Failed to copy text: ', err);
            });
    } else {
        // Fallback for older browsers
        const tempTextArea = document.createElement('textarea');
        tempTextArea.value = codeBlock.textContent;
        document.body.appendChild(tempTextArea);
        tempTextArea.select();
        document.execCommand('copy');
        document.body.removeChild(tempTextArea);

        button.textContent = 'Copied!';
        setTimeout(() => {
            button.textContent = 'Copy Text';
        }, 2000);
    }
}