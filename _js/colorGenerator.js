$(document).ready(function() {
    $('.Colorblock').click(function () {
        var nextColor = getColor();
        $('.Colorblock').css("background-color", nextColor);
        $('.HexBlock').text(nextColor);
    });
});

function getColor() {
    var hexColor = '#';
    var colorPart = [
        1,2,3,4,5,6,7,8,9,
        'a','b','c','d','e','f'
    ];

    for(var i = 0; i <= 5; i++){
        hexColor += colorPart[getRandomInt(0, colorPart.length)];
    }

    return hexColor;
}

function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min)) + min;
}