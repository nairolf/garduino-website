/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.scss';
import 'bootstrap';
import * as d3 from 'd3';
import bsCustomFileInput from "bs-custom-file-input";

bsCustomFileInput.init();

let WIDTH= 1024;
let HEIGHT = 600;

let temperatures = [];

d3.json('/soilmoisture/getAll/temperature01').then(function(data) {
    temperatures = data;

    d3.select('svg')
        .style('width', WIDTH)
        .style('height', HEIGHT);

    var yScale = d3.scaleLinear(); //create the scale
    yScale.range([HEIGHT, 0]); //set the visual range (for example 600 to 0)
    var yDomain = d3.extent(temperatures, function(temperature, index){
        //compare value properties of each item in the data array
        return temperature.value;
    });
    yScale.domain(yDomain);

    //scaleTime maps date values with numeric visual points
    let parseTime = d3.timeParse("%Y-%m-%dT%H:%M:%S%Z");
    let formatTime = d3.timeFormat("%d.%m.%Y-   %H:%M");
    let xScale = d3.scaleTime();
    xScale.range([0,WIDTH]);
    let xDomain = d3.extent(temperatures, function(temperature, index){
        return parseTime(temperature.timestamp);
    });
    xScale.domain(xDomain);

    //pass the appropriate scale in as a parameter
    let bottomAxis = d3.axisBottom(xScale);
    d3.select('svg')
        .append('g') //put everything inside a group
        .call(bottomAxis) //generate the axis within the group
        //move it to the bottom
        .attr('transform', 'translate(0,'+HEIGHT+')');

    let leftAxis = d3.axisLeft(yScale);
    d3.select('svg')
        .append('g')
        //no need to transform, since it's placed correctly initially
        .call(leftAxis);

    d3.select('svg').append("path")
        .datum(temperatures)
        .attr("fill", "none")
        .attr("stroke", "steelblue")
        .attr("stroke-width", 1.5)
        .attr("d", d3.line()
            .x(function(d) { return xScale(parseTime(d.timestamp)) })
            .y(function(d) { return yScale(d.value) })
        );


    // create a tooltip
    let Tooltip = d3.select(".chart")
        .append("div")
        .style("opacity", 0)
        .attr("class", "tooltip")
        .style("background-color", "white")
        .style("border", "solid")
        .style("border-width", "2px")
        .style("border-radius", "5px")
        .style("padding", "5px");

    // Three function that change the tooltip when user hover / move / leave a cell
    let mouseover = function(d) {
        Tooltip
            .style("opacity", 1)
    };
    let mousemove = function(d) {
        Tooltip
            .html(d.value + "°C<br>" + formatTime(parseTime(d.timestamp)))
            .style("left", (d3.mouse(this)[0]+10) + "px")
            .style("top", (d3.mouse(this)[1]) + "px")
            .style("position", "absolute")
    };
    let mouseleave = function(d) {
        Tooltip
            .style("opacity", 0)
    };

    //since no circles exist, we need to select('svg')
    //so that d3 knows where to append the new circles
    d3.select('svg').selectAll('circle')
        .data(temperatures) //attach the data as before
        //find the data objects that have not yet
        //been attached to visual elements
        .enter()
        //for each data object that hasn't been attached,
        //append a <circle> to the <svg>
        .append('circle')
        .attr('cy', function(temperature, index){
            return yScale(temperature.value);
        })
        .attr('cx', function(temperature, index) {
            return xScale(parseTime(temperature.timestamp));
        })
        .on("mouseover", mouseover)
        .on("mousemove", mousemove)
        .on("mouseleave", mouseleave);
});