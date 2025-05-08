<!-- Use the latest jQuery version (full version) -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Add Bootstrap JS and Popper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<style>
    /* Add custom styles as needed */
    .calculator-buttons {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-gap: 5px;
    }

    .calculator-buttons button {
        width: 100%;
        padding: 15px;
        font-size: 18px;
    }

    /* Make the "=" button wider */
    .calculator-buttons button.equal {
        grid-column: span 1;
    }

    #calculatorDisplay {
        grid-column: 1 / -1;
        word-wrap: break-word;
        word-break: break-all;
        -ms-word-break: break-all;
        -ms-word-wrap: break-word;
        height: 120px;
    }

    .overoutput {
        padding-right: 10px;
        text-align: end;
        font-size: 20px;
        min-height: 25px;
    }

    .tempoutput {
        font-size: 12px;
        min-height: 25px;
    }

    .underoutput {
        text-align: end;
        font-size: 40px;
        min-height: 50px;
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

                        <div class="btn-group" style="float: right;">
                            <!-- Tombol Dropdown (di pojok kanan atas) -->
                            <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </button>
                            <!-- Isi Dropdown -->
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?php echo site_url('users/kalkulator/kalkulator'); ?>"><i class="fa fa-calculator"></i> Angsuran</a></li>
                                <li><a href="<?php echo site_url('users/kalkulator/kalkulator_standar'); ?>"><i class="fa fa-calculator"></i> Kalkulator</a></li>
                                <!-- <li><a href="<?php echo site_url('#'); ?>" onclick="return false;"><i
                                                    class="fa fa-calculator"></i> Murabahah</a></li>
                                        <li><a href="<?php echo site_url('#'); ?>" onclick="return false;"><i
                                                    class="fa fa-calculator"></i> Zakat</a></li> -->
                            </ul>
                        </div>
                    </div>
                    <!-- Membersihkan float -->
                    <legend class="text-bold"><i class="fa fa-calculator"></i> Kalkulator</legend>
                    <div class="calculator-buttons">
                        <div id="calculatorDisplay" class="form-control text-right" readonly>
                            <div class="overoutput"></div>
                            <div class="underoutput"></div>
                            <div class="tempoutput"></div>
                        </div>
                        <button class="btn btn-info clear">CE</button>
                        <button class="btn btn-danger delete">⌫</button>
                        <button class="btn btn-warning operation">%</button>
                        <button class="btn btn-warning operation">/</button>
                        <button class="btn btn-secondary number">7</button>
                        <button class="btn btn-secondary number">8</button>
                        <button class="btn btn-secondary number">9</button>
                        <button class="btn btn-warning operation">x</button>
                        <button class="btn btn-secondary number">4</button>
                        <button class="btn btn-secondary number">5</button>
                        <button class="btn btn-secondary number">6</button>
                        <button class="btn btn-warning operation">-</button>
                        <button class="btn btn-secondary number">1</button>
                        <button class="btn btn-secondary number">2</button>
                        <button class="btn btn-secondary number">3</button>
                        <button class="btn btn-success operation">+</button>
                        <button class="btn btn-secondary number">0</button>
                        <button class="btn btn-secondary number">00</button>
                        <button class="btn btn-warning number">.</button>
                        <button class="btn btn-primary result">=</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const number = document.querySelectorAll('.number')
    const operation = document.querySelectorAll('.operation')
    const resultLast = document.querySelector('.result')
    const clear = document.querySelector('.clear')
    const del = document.querySelector('.delete')
    const overoutput = document.querySelector('.overoutput')
    const underoutput = document.querySelector('.underoutput')
    const tempoutput = document.querySelector('.tempoutput')

    var output1 = ''
    var output2 = ''
    var result = null
    var operationLast = ''
    var oneDot = false

    number.forEach(number => {
        number.addEventListener('click', (e) => {
            if (e.target.innerText === '.' && !oneDot) {
                oneDot = true
            } else if (e.target.innerText === '.' && oneDot) {
                return
            }
            output2 += e.target.innerText
            underoutput.innerText = output2
        })
    })

    operation.forEach((operation) => {
        operation.addEventListener('click', (e) => {
            if (!output2) return
            oneDot = false
            const operationName = e.target.innerText
            if (output1 && output2 && operationLast) {
                mathOperation()
            } else {
                result = parseFloat(output2)
            }
            clearVar(operationName)
            operationLast = operationName;
        })
    })

    function clearVar(name = '') {
        output1 += output2 + ' ' + name + ' '
        overoutput.innerText = output1
        underoutput.innerText = ''
        output2 = ''
        tempoutput.innerText = result
    }

    function mathOperation() {
        if (operationLast === "x") {
            result = parseFloat(result) * parseFloat(output2);
        } else if (operationLast === "+") {
            result = parseFloat(result) + parseFloat(output2);
        } else if (operationLast === "-") {
            result = parseFloat(result) - parseFloat(output2);
        } else if (operationLast === "/") {
            result = parseFloat(result) / parseFloat(output2);
        } else if (operationLast === "%") {
            result = parseFloat(result) % parseFloat(output2);
        }
    }

    resultLast.addEventListener('click', (e) => {
        if (!output1 || !output2) return
        oneDot = false
        mathOperation()
        clearVar()
        underoutput.innerText = result
        tempoutput.innerText = ''
        output2 = result
        output1 = ''
    })

    clear.addEventListener('click', (e) => {
        underoutput.innerText = ''
        overoutput.innerText = ''
        tempoutput.innerText = ''
        output1 = ''
        output2 = ''
        result = ''
    })

    del.addEventListener('click', (e) => {
        underoutput.innerText = underoutput.innerText.toString().slice(0, -1)
        output2 = output2.toString().slice(0, -1)
    })

    window.addEventListener('keydown', (e) => {
        if (
            e.key === '0' ||
            e.key === '1' ||
            e.key === '2' ||
            e.key === '3' ||
            e.key === '4' ||
            e.key === '5' ||
            e.key === '6' ||
            e.key === '7' ||
            e.key === '8' ||
            e.key === '9' ||
            e.key === '.'
        ) {
            clicknumber(e.key)
        } else if (
            e.key === '+' ||
            e.key === '-' ||
            e.key === '/' ||
            e.key === '%'
        ) {
            clickoperation(e.key)
        } else if (e.key === '*') {
            clickoperation('x')
        } else if (e.key === 'Enter' || e.key === '=') {
            clickresult()
        } else if (e.key === 'Backspace') {
            clickdel()
        } else if (e.key === 'Delete') {
            clickclear()
        }
    })

    function clicknumber(key) {
        number.forEach((button) => {
            if (button.innerText === key) {
                button.click()
            }
        })
    }

    function clickoperation(key) {
        operation.forEach((button) => {
            if (button.innerText === key) {
                button.click()
            }
        })
    }

    function clickresult() {
        resultLast.click()
    }

    function clickdel() {
        del.click()
    }

    function clickclear() {
        clear.click()
    }
</script>