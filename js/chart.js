var values = [],
    labels = [],
    legends = true,
    legendsElement = $('#TicketByDepartmentLegends'),
    colors = ['#fcaf17','#aa85bc','#7cbe88','#e67157'];

$("#TicketByDepartment tr").each(function () {
  values.push(parseInt($("td", this).text(), 10));
  labels.push($("th", this).text());
});

$("#TicketByDepartment").hide();
var r = Raphael("DonutTicketsByDepartment", 200, 200);
r.donutChart(100, 100, 88, 35, values, labels, colors, legends, legendsElement, colors);

