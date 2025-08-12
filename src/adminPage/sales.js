
  var filterSelect = document.getElementById("filter");
  filterSelect.value = "daily";
  updateSummary(filterSelect.value);

filterSelect.addEventListener("change", function() {
  var selectedFilter = filterSelect.value;
  updateSummary(selectedFilter);
});

// Function to update the summary based on the selected filter
function updateSummary(filter) {
  // Clear the existing summary
  var summaryContainer = document.querySelector(".summary-container");
  summaryContainer.innerHTML = "Loading...";

  // Make an AJAX request to fetch the payment data based on the selected filter
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "fetch_payment_data.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      // Process the received payment data and update the summary
      var paymentData = JSON.parse(xhr.responseText);
      displaySummary(paymentData);
    } else if (xhr.readyState === 4 && xhr.status !== 200) {
      // Handle any errors that occur during the AJAX request
      summaryContainer.innerHTML = "Failed to fetch payment data.";
    }
  };
  xhr.send("filter=" + filter);
}

// Function to display the summary based on the received payment data
function displaySummary(paymentData) {
  var summaryContainer = document.querySelector(".summary-container");
  summaryContainer.innerHTML = "";

  if(!paymentData){
    summaryContainer.innerHTML = "No transaction exist";
    return;
  }

  // Create a table element
  var table = document.createElement("table");
  table.classList.add("summary-table");

  // Create the table headers
  var tableHead = document.createElement("thead");
  var headerRow = document.createElement("tr");
  var headers = ["Payment ID", "Payment Date", "Payment By", "Payment Amount"];

  headers.forEach(function(header) {
    var th = document.createElement("th");
    th.textContent = header;
    if(header == "Payment By"){
      th.classList.add("username-cell");
    }
    headerRow.appendChild(th);
  });

  tableHead.appendChild(headerRow);
  table.appendChild(tableHead);

  // Create the table body and populate it with data
  var tableBody = document.createElement("tbody");

  var total = 0;

  paymentData.forEach(function(payment) {
    var row = document.createElement("tr");

    var paymentIdCell = document.createElement("td");
    paymentIdCell.textContent = payment.payment_id;
    row.appendChild(paymentIdCell);

    var paymentDateCell = document.createElement("td");
    paymentDateCell.textContent = payment.payment_date;
    row.appendChild(paymentDateCell);

    var paidByCell = document.createElement("td");
    paidByCell.textContent = payment.username;
    paidByCell.classList.add("username-cell");
    row.appendChild(paidByCell);

    var paymentAmountCell = document.createElement("td");
    paymentAmountCell.textContent = payment.payment_amount;
    row.appendChild(paymentAmountCell);

    total += parseInt(payment.payment_amount);

    tableBody.appendChild(row);
  });

  var totalRow = document.createElement("tr");
  var totalTextCell = document.createElement("td");
  totalTextCell.textContent = "Total";
  totalTextCell.colSpan = 3; // Span the total text cell across two columns
  totalTextCell.classList.add("total-cell");
  totalRow.appendChild(totalTextCell);

  var totalCell = document.createElement("td");
  totalCell.textContent = total;
  totalRow.appendChild(totalCell);

  tableBody.appendChild(totalRow);


  table.appendChild(tableBody);

  // Append the table to the summary container
  summaryContainer.appendChild(table);
}
