<!-- Include jQuery first -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!-- SweetAlert CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<style>
  .swal2-popup {
    width: 95%;
    /* Adjust the width as needed */
    text-align: left;
    /* Align text to the left */
  }

  .swal2-content {
    text-align: left;
    /* Align text to the left */
    padding: 0;
  }
</style>

<!-- Main content -->
<div class="container">
  <!-- Content area -->
  <div class="content">
    <!-- Dashboard content -->
    <div class="row">
      <div class="panel panel-flat">
        <?php
        echo $this->session->flashdata('msg');
        ?>
        <div class="panel-body">
          <div class="navigation-buttons">
            <div class="btn-group" style="float: left;">
              <!-- Tombol Back (di pojok kiri atas) -->
              <a href="javascript:history.go(-1);" class="btn btn-light btn-sm">
                <i class="fa fa-arrow-left"></i>
              </a>
            </div>

            <div class="btn-group" style="float: right;">
              <!-- Tombol Dropdown (di pojok kanan atas) -->
              <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bars"></i>
              </button>
              <!-- Isi Dropdown -->
              <ul class="dropdown-menu dropdown-menu-right" role="menu">
                <li><a href="<?php echo site_url('users/kalkulator/kalkulator'); ?>"><i class="fa fa-calculator"></i> Angsuran</a></li>
                <li><a href="<?php echo site_url('users/kalkulator/kalkulator_standar'); ?>"><i class="fa fa-calculator"></i> Kalkulator</a></li>
                <!-- <li><a href="<?php echo site_url('#'); ?>" onclick="return false;"><i class="fa fa-calculator"></i> Murabahah</a></li>
                  <li><a href="<?php echo site_url('#'); ?>" onclick="return false;"><i class="fa fa-calculator"></i> Zakat</a></li> -->

              </ul>
            </div>
          </div>
          <!-- Membersihkan float -->
          <div class="clearfix"></div>
          <fieldset class="content-group">
            <legend class="text-bold"><i class="fa fa-calculator"></i> Kalkulator Simulasi Angsuran</legend>

            <!-- Form for loan simulation -->
            <form id="loanForm">
              <div class="form-group">
                <label for="loan_amount">Jumlah Pembiayaan (IDR):</label>
                <input type="number" id="loan_amount" class="form-control" placeholder="Contoh : 10.000.000" required>
              </div>

              <div class="form-group">
                <label for="interest_rate">Rate (% per bulan):</label>
                <input type="number" id="interest_rate" class="form-control" placeholder="Contoh : 1.2">
              </div>

              <div class="form-group">
                <label for="loan_term">Jangka Waktu Pembiayaan (bulan):</label>
                <input type="number" id="loan_term" class="form-control" placeholder="Contoh : 36" required>
              </div>

              <div class="form-check" style="display: flex;">
                <div style="margin-right: 10px;">
                  <input type="radio" class="form-check-input" id="flat_interest" name="interest_method" value="flat" checked>
                  <label class="form-check-label" for="flat_interest">Flat</label>
                </div>

                <div style="margin-right: 10px;">
                  <input type="radio" class="form-check-input" id="effective_interest" name="interest_method" value="effective">
                  <label class="form-check-label" for="effective_interest">Effective </label>
                </div>

                <div>
                  <input type="radio" class="form-check-input" id="annuity_interest" name="interest_method" value="annuity">
                  <label class="form-check-label" for="annuity_interest">Annuity </label>
                </div>
              </div>


              <div style="text-align: right;">
                <button type="button" onclick="calculateLoan()" class="btn btn-danger" data-toggle="modal" data-target="#resultModal">Hitung</button>
              </div>
            </form>
          </fieldset>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript for loan calculation -->
<script>
  function calculateLoan() {
    var loanAmount = parseFloat(document.getElementById('loan_amount').value);
    var interestRateInput = document.getElementById('interest_rate').value;
    var interestRate = interestRateInput ? parseFloat(interestRateInput) : 0;
    var loanTerm = parseInt(document.getElementById('loan_term').value);
    var interestMethod = getSelectedInterestMethod();

    // Validate input
    if (isNaN(loanAmount) || isNaN(interestRate) || isNaN(loanTerm) || loanAmount <= 0 || interestRate < 0 || loanTerm <= 0) {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Masukkan angka yang valid untuk jumlah pembiayaan, tingkat rate, dan jangka waktu pembiayaan.',
      });
      return;
    }

    // Perform loan calculation based on the selected interest method
    var result;
    switch (interestMethod) {
      case 'flat':
        result = calculateFlatInstallments(loanAmount, interestRate, loanTerm);
        break;
      case 'effective':
        result = calculateEffectiveInstallments(loanAmount, interestRate, loanTerm);
        break;
      case 'annuity':
        result = calculateAnnuityInstallments(loanAmount, interestRate, loanTerm);
        break;
      default:
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Metode rate tidak valid.',
        });
        return;
    }

    // Display result using SweetAlert
    Swal.fire({
      title: 'Hasil Kalkulasi',
      html: result,
      showCloseButton: true,
    });
  }


  function getSelectedInterestMethod() {
    var radioButtons = document.getElementsByName('interest_method');
    for (var i = 0; i < radioButtons.length; i++) {
      if (radioButtons[i].checked) {
        return radioButtons[i].value;
      }
    }
    return '';
  }

  function calculateFlatInstallments(loanAmount, interestRate, loanTerm) {
    var monthlyInstallments = [];
    var monthlyInterestRate = interestRate / 100 / 12;
    var totalInterest = 0;
    var totalPrincipal = 0;

    for (var i = 0; i <= loanTerm; i++) {
      var interestPayment = (i === 0) ? 0 : loanAmount * monthlyInterestRate;
      var principalPayment = (i === 0) ? 0 : loanAmount / loanTerm;
      totalInterest += interestPayment;
      totalPrincipal += principalPayment;

      monthlyInstallments.push({
        month: i,
        principal: formatRupiah(principalPayment.toFixed(2)),
        interest: formatRupiah(interestPayment.toFixed(2)),
        total: formatRupiah((principalPayment + interestPayment).toFixed(2)),
        balance: formatRupiah((loanAmount - totalPrincipal).toFixed(2))
      });
    }

    return generateResultHTML(monthlyInstallments, totalInterest, totalPrincipal, loanAmount);
  }

  function calculateAnnuityInstallments(loanAmount, interestRate, loanTerm) {
    var monthlyInstallments = [];
    var remainingBalance = loanAmount;
    var monthlyInterestRate = interestRate / 100 / 12;
    var totalInterest = 0;
    var totalPrincipal = 0;

    for (var i = 0; i <= loanTerm; i++) {
      var interestPayment = (i === 0) ? 0 : remainingBalance * monthlyInterestRate;
      var principalPayment = (i === 0) ? 0 : loanAmount / loanTerm;
      totalInterest += interestPayment;
      totalPrincipal += principalPayment;

      monthlyInstallments.push({
        month: i,
        principal: formatRupiah(principalPayment.toFixed(2)),
        interest: formatRupiah(interestPayment.toFixed(2)),
        total: formatRupiah((principalPayment + interestPayment).toFixed(2)),
        balance: formatRupiah((remainingBalance - totalPrincipal).toFixed(2))
      });

      remainingBalance -= principalPayment;
    }

    return generateResultHTML(monthlyInstallments, totalInterest, totalPrincipal, loanAmount);
  }

  function calculateEffectiveInstallments(loanAmount, interestRate, loanTerm) {
    var monthlyInstallments = [];
    var remainingBalance = loanAmount;
    var monthlyInterestRate = interestRate / 100 / 12;
    var annuityFactor = (monthlyInterestRate * Math.pow(1 + monthlyInterestRate, loanTerm)) / (Math.pow(1 + monthlyInterestRate, loanTerm) - 1);

    for (var i = 0; i < loanTerm; i++) {
      var interestPayment = remainingBalance * monthlyInterestRate;
      var principalPayment = loanAmount * monthlyInterestRate * Math.pow(1 + monthlyInterestRate, i) / (Math.pow(1 + monthlyInterestRate, loanTerm) - 1);
      var monthlyPayment = principalPayment + interestPayment;

      monthlyInstallments.push({
        month: i + 1,
        principal: formatRupiah(principalPayment.toFixed(2)),
        interest: formatRupiah(interestPayment.toFixed(2)),
        total: formatRupiah(monthlyPayment.toFixed(2)),
        balance: formatRupiah((remainingBalance - principalPayment).toFixed(2))
      });

      remainingBalance -= principalPayment;
    }

    return generateResultHTML(monthlyInstallments, (monthlyPayment * loanTerm - loanAmount), loanAmount, loanAmount);
  }


  function generateResultHTML(monthlyInstallments, totalInterest, totalPrincipal, loanAmount) {
    var resultHTML = '';
    resultHTML += '<div class="table-responsive">';
    resultHTML += '<table class="table table-bordered table-striped table-hover"><thead><tr><th>Bulan</th><th>Pokok</th><th>Margin</th><th>Total Angsuran</th><th>Sisa Pembiayaan</th></tr></thead><tbody>';

    monthlyInstallments.forEach(function(installment) {
      resultHTML += '<tr>';
      resultHTML += '<td>' + installment.month + '</td>';
      resultHTML += '<td>' + installment.principal + '</td>';
      resultHTML += '<td>' + installment.interest + '</td>';
      resultHTML += '<td>' + installment.total + '</td>';
      resultHTML += '<td>' + installment.balance + '</td>';
      resultHTML += '</tr>';
    });

    resultHTML += '</tbody></table>';
    resultHTML += '<p>&nbsp<strong>Total Margin: ' + formatRupiah(totalInterest.toFixed(2)) + '</strong></p>';
    resultHTML += '<p>&nbsp<strong>Total Pokok: ' + formatRupiah(totalPrincipal.toFixed(2)) + '</strong></p>';
    resultHTML += '<p>&nbsp<strong>Total Angsuran: ' + formatRupiah((totalPrincipal + totalInterest).toFixed(2)) + '</strong></p>';
    resultHTML += '</div>'; // Close the table-responsive div
    resultHTML += '<br><br>';
    return resultHTML;
  }

  function formatRupiah(angka) {
    var reverse = angka.toString().split('').reverse().join(''),
      ribuan = reverse.match(/\d{1,3}/g);
    ribuan = ribuan.join('.').split('').reverse().join('');
    return 'Rp ' + ribuan;
  }
</script>