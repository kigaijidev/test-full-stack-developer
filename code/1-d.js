function compressString(input) {
    let compressed = "";
    let currentChar = input[0];
    let charCount = 1;

    for (let idx = 1; idx < input.length; idx++) {
        if (input[idx] === currentChar) {
            charCount++;
        } else {
            compressed += currentChar + (charCount > 0 ? charCount : '');
            currentChar = input[idx];
            charCount = 1;
        }
    }

    compressed += currentChar + (charCount > 0 ? charCount : '');

    console.log(compressed)
    return true;
}

compressString('kkkktttrrrrrrrrrr')
compressString('p555ppp7www')