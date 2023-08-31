// Slick Slider
$(".responsive").slick({
  dots: false,
  infinite: false,
  speed: 300,
  slidesToShow: 3,
  slidesToScroll: 1,
  // autoplay: true,
  // autoplaySpeed: 2000,
  responsive: [
    {
      breakpoint: 1560,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
        infinite: true,
        dots: false,
      },
    },
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
        infinite: true,
        dots: false,
      },
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
      },
    },
  ],
});

// BarChasrt
var ctx = document.getElementById("barChart").getContext("2d");
var lineCtx = document.getElementById("lineChart").getContext("2d");
var doughnutCtx1 = document.getElementById("doughnutChart1").getContext("2d");
var doughnutCtx2 = document.getElementById("doughnutChart2").getContext("2d");
var doughnutCtx3 = document.getElementById("doughnutChart3").getContext("2d");

// Bar Chart configuration
var chartConfig = {
  type: "bar",
  data: {
    labels: ["Label 1", "Label 2", "Label 3"],
    datasets: [
      {
        label: "Lorem ipsum",
        data: [170, 200, 130],
        backgroundColor: "#33343F",
        barPercentage: 1.0,
        categoryPercentage: 0.5,
      },
      {
        label: "Lorem ipsum",
        data: [80, 50, 70],
        backgroundColor: "#FF8504",
        barPercentage: 1.0,
        categoryPercentage: 0.5,
      },
    ],
  },
  options: {
    responsive: true,
    scales: {
      x: {
        display: false,
      },
      y: {
        beginAtZero: true,
        ticks: {
          stepSize: 50,
          callback: function (value, index, values) {
            return value % 50 === 0 ? value : "";
          },
        },
      },
    },
  },
};

// Line Chart configuration
var lineChartConfig = {
  type: "line",
  data: {
    labels: [
      "Jan",
      "Feb",
      "Mar",
      "Apr",
      "May",
      "Jun",
      "Jul",
      "Aug",
      "Sep",
      "Oct",
      "Nov",
      "Dec",
    ],
    datasets: [
      {
        label: "Line Data",
        data: [100, 200, 130, 120, 80, 54, 90, 120, 180, 60, 10, 170],
        borderColor: "rgba(255, 159, 64, 1)",
        borderWidth: 4,
        fill: false,
      },
    ],
  },
  options: {
    responsive: true,
    scales: {
      x: {
        beginAtZero: true,
      },
      y: {
        beginAtZero: true,
        ticks: {
          stepSize: 50,
          callback: function (value, index, values) {
            return value % 50 === 0 ? value : "";
          },
        },
      },
    },
  },
};

// Doughnut chart configuration 1
var doughnutChartConfig1 = {
  type: "doughnut",
  data: {
    labels: ["Lorem Ipsum", "Lorem Ipsum", "Lorem Ipsum"],
    datasets: [
      {
        data: [45, 20, 35], // Data values for the doughnut chart
        backgroundColor: ["#818181", "#33343F", "#D2D2D2"],
        borderWidth: 1,
      },
    ],
  },
  options: {
    responsive: true, // Adjust the cutout percentage for the doughnut hole
  },
};
// Doughnut chart configuration 2
var doughnutChartConfig2 = {
  type: "doughnut",
  data: {
    labels: ["Lorem Ipsum", "Lorem Ipsum", "Lorem Ipsum"],
    datasets: [
      {
        data: [45, 20, 35], // Data values for the doughnut chart
        backgroundColor: ["#5D5F7C", "#424789", "#8C8FB1"],
        borderWidth: 1,
      },
    ],
  },
  options: {
    responsive: true, // Adjust the cutout percentage for the doughnut hole
  },
};
// Doughnut chart configuration 3
var doughnutChartConfig3 = {
  type: "doughnut",
  data: {
    labels: ["Lorem Ipsum", "Lorem Ipsum", "Lorem Ipsum"],
    datasets: [
      {
        data: [45, 20, 35], // Data values for the doughnut chart
        backgroundColor: ["#FF8300", "#DC7100", "#FFC485"],
        borderWidth: 1,
      },
    ],
  },
  options: {
    responsive: true, // Adjust the cutout percentage for the doughnut hole
  },
};

var myChart = new Chart(ctx, chartConfig);
var lineChart = new Chart(lineCtx, lineChartConfig);
var doughnutChart = new Chart(doughnutCtx1, doughnutChartConfig1);
var doughnutChart = new Chart(doughnutCtx2, doughnutChartConfig2);
var doughnutChart = new Chart(doughnutCtx3, doughnutChartConfig3);
