<!DOCTYPE html>
<html>
<head>
  <title>Select Month and Year</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="//code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    $(function() {
      $("#datepicker").datepicker({
        dateFormat: "yy-mm",
        changeMonth: true,
        changeYear: true,
        yearRange: "2022:2024",
        monthNames: ["May", "November"],
        monthNamesShort: ["May", "Nov"],
        beforeShowMonth: function(date) {
          return (date.getMonth() == 10 || date.getMonth() == 4);
        },
        onClose: function(dateText, inst) {
          $("#selectedDate").val(dateText);
        }
      });
    });
  </script>
</head>
<body>

  <label for="datepicker">Select Month and Year:</label>
  <input type="text" id="datepicker">
  <br>
  <label for="selectedDate">Selected Date:</label>
  <input type="text" id="selectedDate" readonly>

</body>
</html>
