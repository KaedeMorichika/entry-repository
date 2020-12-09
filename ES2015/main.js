$(document).ready(function(){
    'use strict';
    paper.install(window);
    paper.setup($('#main_canvas'));

    let c = Shape.Circle(200, 200, 50);
    c.fillColor = 'green';

    paper.view.draw();
});