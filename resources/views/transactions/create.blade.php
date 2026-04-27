@extends('layouts.app')

@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('vouchers.index') }}">Voucher</a></li>
            <li class="breadcrumb-item active">{{ $title_page }}</li>
        </ol>
    </nav>
</div>

<div class="container-fluid py-4">
    <form id="transactionForm">
    @csrf
        <div class="row mb-3">
            <div class="col-12">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-primary font-weight-bold">Data Utama Transaksi</h5>
                        <a href="{{ route('transactions.index') }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                    <div class="card-body p-4">
                        <div class="section-container mb-5">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small text-uppercase font-weight-bold">Nomor Invoice</label>
                                    <input type="text" name="invoice_number" class="form-control bg-light border-0 font-weight-bold" value="{{ $invoice_number }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small text-uppercase font-weight-bold">Pilih Asuransi</label>
                                    <select name="insurance_id" id="insurance_id" class="form-control custom-select border-primary-light" required>
                                        <option value="">-- Pilih Asuransi --</option>
                                        @foreach($insurances as $insurance)
                                            <option value="{{ $insurance['id'] }}">{{ $insurance['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3 d-none">
                                    <label class="form-label text-muted small text-uppercase font-weight-bold">Voucher Otomatis</label>
                                    <div id="voucher-status">
                                        <input type="text" id="voucher_display" class="form-control bg-light border-0" placeholder="Pilih asuransi dulu..." readonly>
                                        <input type="hidden" name="voucher_id" id="voucher_id">
                                    </div>
                                    <small id="voucher_info" class="text-success font-italic d-none"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-primary font-weight-bold">Detail Tindakan Medis</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="section-container">
                            <div class="section-title mb-4 d-flex justify-content-between align-items-center">
                                <button type="button" class="btn btn-primary btn-sm shadow-sm px-3" id="addRow">
                                    <i class="fas fa-plus mr-1"></i> Tambah Tindakan
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="detailsTable">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="border-0 text-muted small text-uppercase" style="width: 30%">Tindakan</th>
                                            <th class="border-0 text-muted small text-uppercase">Harga</th>
                                            <th class="border-0 text-muted small text-uppercase" style="width: 10%">Qty</th>
                                            <th class="border-0 text-muted small text-uppercase">Potongan/Item</th>
                                            <th class="border-0 text-muted small text-uppercase">Subtotal</th>
                                            <th class="border-0 text-muted small text-uppercase text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detailsBody">
                                        <!-- Rows added via JS -->
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-hover border-0 bg-light-soft">
                                    <tbody>
                                        <tr>
                                            <td colspan="4" class="text-right py-3">Total Sebelum Diskon Voucher</td>
                                            <td class="py-3"><span id="display_subtotal">Rp 0</span></td>
                                            <td><input type="hidden" name="subtotal" id="subtotal" value="0" readonly></td>
                                        </tr>
                                        <tr class="text-success">
                                            <td colspan="4" class="text-right py-3">Diskon Voucher</td>
                                            <td class="py-3"><span id="display_voucher_discount">- Rp 0</span></td>
                                            <td><input type="hidden" name="voucher_discount" id="voucher_discount" value="0" readonly></td>
                                        </tr>
                                        <tr class="bg-primary text-white">
                                            <td colspan="4" class="text-right py-3">GRAND TOTAL</td>
                                            <td class="py-3 font-weight-bolder" style="font-size: 1.2rem;"><span id="display_grand_total">Rp 0</span></td>
                                            <td><input type="hidden" name="grand_total" id="grand_total" value="0" readonly></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mt-5 text-end">
                            <button type="submit" class="btn btn-primary px-5 shadow-sm font-weight-bold" id="btnSubmit">
                                Simpan Transaksi <i class="fas fa-save ml-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Template for Table Row -->
<template id="rowTemplate">
    <tr class="detail-row">
        <td>
            <select name="procedure_id" class="form-control procedure-select border-0 bg-light-soft" required>
                <option value="">-- Pilih Tindakan --</option>
                @foreach($procedures as $procedure)
                    <option value="{{ $procedure['id'] }}">{{ $procedure['name'] }}</option>
                @endforeach
            </select>
            <input type="hidden" name="procedure_name"> <!-- hidden -->
            <input type="hidden" name="price_id"> <!-- hidden -->
            <div class="small text-muted mt-1 price-dates"></div>
        </td>
        <td>
            <input type="text" name="price_text" class="form-control border-0 bg-transparent font-weight-bold" readonly value="0"> <!-- text -->
            <input type="hidden" name="price" id="price_val" class="form-control border-0 bg-transparent font-weight-bold" readonly value="0"> <!-- hidden -->
            <input type="hidden" name="price_start_date"> <!-- hidden -->
            <input type="hidden" name="price_end_date"> <!-- hidden -->
        </td>
        <td>
            <input type="number" name="qty" class="form-control border-primary-light" value="1" min="1" required>
        </td>
        <td>
            <input type="text" name="discount_per_item_text" class="form-control border-primary-light" value="0" min="0" readonly>
            <input type="hidden" name="discount_per_item" class="form-control border-primary-light" value="0" min="0">
        </td>
        <td>
            <input type="text" name="row_subtotal_text" class="form-control border-0 bg-transparent font-weight-bold" readonly value="0"> <!-- text -->
            <input type="hidden" name="row_subtotal" class="form-control border-0 bg-transparent font-weight-bold" readonly value="0"> <!-- hidden -->
        </td>
        <td class="text-center align-middle">
            <button type="button" class="btn btn-link text-danger remove-row"><i class="fas fa-trash-alt"></i></button>
        </td>
    </tr>
</template>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const detailsBody = document.getElementById('detailsBody');
    const rowTemplate = document.getElementById('rowTemplate');
    const insuranceSelect = document.getElementById('insurance_id');
    const addRowBtn = document.getElementById('addRow');
    const transactionForm = document.getElementById('transactionForm');
    
    let activeVoucher = null;

    // Add initial row
    addRow();

    // Event: Add row
    addRowBtn.addEventListener('click', addRow);

    // Event: change insureance
    insuranceSelect.addEventListener('change', function() {
        const insuranceId = this.value;

        // Re-fetch prices and discounts for existing procedure rows
        document.querySelectorAll('.detail-row').forEach(row => {
            const procSelect = row.querySelector('.procedure-select');
            if (procSelect && procSelect.value) {
                procSelect.dispatchEvent(new Event('change'));
            }
        });

        if (!insuranceId) {
            resetVoucher();
            return;
        }

        fetch(`{{ route('transactions.get-voucher') }}?insurance_id=${insuranceId}`)
            .then(res => res.json())
            .then(voucher => {
                console.log(voucher);
                
                if (voucher) {
                    activeVoucher = voucher;
                    document.getElementById('voucher_display').value = voucher.name + ' (' + voucher.code + ')';
                    document.getElementById('voucher_id').value = voucher.id;
                    document.getElementById('voucher_info').textContent = `Diskon: ${voucher.type === 'percentage' ? voucher.value + '%' : 'Rp ' + formatIDR(voucher.value)}`;
                } else {
                    resetVoucher("Tidak ada voucher aktif");
                }
                calculateGrandTotal();
            });
    });

    function addRow() {
        const clone = rowTemplate.content.cloneNode(true);
        const row = clone.querySelector('tr');
        
        // Handle Procedure Change
        const procSelect = row.querySelector('.procedure-select');
        procSelect.addEventListener('change', function() {
            const procId = this.value;
            const rowEl = this.closest('tr');
            if (!procId) return;

            // Set procedure name hidden input
            rowEl.querySelector('[name="procedure_name"]').value = this.options[this.selectedIndex].text;

            fetch(`{{ route('transactions.get-price') }}?procedure_id=${procId}&insurance_id=${insuranceSelect.value}`)
                .then(res => res.json())
                .then(price => {
                console.log(price);
                
                    if (price['activePrice'] && Object.keys(price['activePrice']).length > 0) {
                        let startDate = price['activePrice'].start_date;
                        let endDate = price['activePrice'].end_date;
                        
                        // Handle if the date is an object (e.g., {'value': '2023-01-01'})
                        if (startDate && typeof startDate === 'object') startDate = startDate.value;
                        if (endDate && typeof endDate === 'object') endDate = endDate.value;

                        rowEl.querySelector('[name="price_text"]').value = formatIDR(price['activePrice'].unit_price) || 0;
                        rowEl.querySelector('[name="price"]').value = price['activePrice'].unit_price || 0;
                        rowEl.querySelector('[name="price_id"]').value = price['activePrice'].id || '';
                        rowEl.querySelector('[name="price_start_date"]').value = startDate || '';
                        rowEl.querySelector('[name="price_end_date"]').value = endDate || '';
                        rowEl.querySelector('.price-dates').textContent = `Berlaku: ${startDate} s/d ${endDate}`;
                        rowEl.querySelector('[name="discount_per_item"]').value = price['discount_per_item'] || 0;
                        rowEl.querySelector('[name="discount_per_item_text"]').value = formatIDR(price['discount_per_item']) || 0;
                    } else {
                        rowEl.querySelector('[name="price_text"]').value = 0;
                        rowEl.querySelector('[name="price"]').value = 0;
                        rowEl.querySelector('[name="price_id"]').value = '';
                        rowEl.querySelector('[name="price_start_date"]').value = '';
                        rowEl.querySelector('[name="price_end_date"]').value = '';
                        rowEl.querySelector('[name="discount_per_item"]').value = 0;
                        rowEl.querySelector('[name="discount_per_item_text"]').value = 0;
                        rowEl.querySelector('.price-dates').textContent = "Tidak ada harga berlaku";
                    }
                    calculateRowSubtotal(rowEl);
                });
        });

        // Handle Input Changes
        row.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', () => calculateRowSubtotal(row));
        });

        // Handle Remove Row
        row.querySelector('.remove-row').addEventListener('click', function() {
            if (detailsBody.querySelectorAll('tr').length > 1) {
                this.closest('tr').remove();
                calculateGrandTotal();
            } else {
                alert("Minimal harus ada satu tindakan.");
            }
        });

        detailsBody.appendChild(clone);
    }

    function calculateRowSubtotal(row) {
        const price = parseFloat(row.querySelector('[name="price"]').value) || 0;
        const qty = parseInt(row.querySelector('[name="qty"]').value) || 0;
        const discount = parseFloat(row.querySelector('[name="discount_per_item"]').value) || 0;
        
        const subtotal = (price * qty) - discount;
        row.querySelector('[name="row_subtotal_text"]').value = formatIDR(subtotal);
        row.querySelector('[name="row_subtotal"]').value = subtotal;
        
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let totalSubtotal = 0;
        let totalVoucher = 0;
        
        document.querySelectorAll('.detail-row').forEach(row => {
            const price = parseFloat(row.querySelector('[name="price"]').value) || 0;
            const qty = parseInt(row.querySelector('[name="qty"]').value) || 0;
            const discount = parseFloat(row.querySelector('[name="discount_per_item"]').value) || 0;
            
            totalSubtotal += (price * qty);
            totalVoucher += discount;
        });

        const grandTotal = Math.max(0, totalSubtotal - totalVoucher);

        document.getElementById('subtotal').value = totalSubtotal;
        document.getElementById('voucher_discount').value = totalVoucher;
        document.getElementById('grand_total').value = grandTotal;

        document.getElementById('display_subtotal').textContent = 'Rp ' + formatIDR(totalSubtotal);
        document.getElementById('display_voucher_discount').textContent = '- Rp ' + formatIDR(totalVoucher);
        document.getElementById('display_grand_total').textContent = 'Rp ' + formatIDR(grandTotal);
    }

    function resetVoucher(text = "Pilih asuransi dulu...") {
        activeVoucher = null;
        document.getElementById('voucher_display').value = text;
        document.getElementById('voucher_id').value = "";
        document.getElementById('voucher_info').textContent = "";
        calculateGrandTotal();
    }

    function formatIDR(amount) {
        return new Intl.NumberFormat('id-ID').format(amount);
    }

    // Form Submission
    transactionForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const btnSubmit = document.getElementById('btnSubmit');
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = 'Menyimpan... <i class="fas fa-spinner fa-spin ml-2"></i>';

        const formData = {
            _token: document.querySelector('[name="_token"]').value,
            invoice_number: document.querySelector('[name="invoice_number"]').value,
            insurance_id: document.querySelector('[name="insurance_id"]').value,
            voucher_id: document.querySelector('[name="voucher_id"]').value,
            subtotal: document.querySelector('[name="subtotal"]').value,
            total_discount: document.querySelector('[name="voucher_discount"]').value,
            grand_total: document.querySelector('[name="grand_total"]').value,
            details: []
        };

        document.querySelectorAll('.detail-row').forEach(row => {
            const sub = parseFloat(row.querySelector('[name="row_subtotal"]').value);
            formData.details.push({
                procedure_id: row.querySelector('[name="procedure_id"]').value,
                procedure_name: row.querySelector('[name="procedure_name"]').value,
                price_id: row.querySelector('[name="price_id"]').value,
                price: parseFloat(row.querySelector('[name="price"]').value),
                price_start_date: row.querySelector('[name="price_start_date"]').value,
                price_end_date: row.querySelector('[name="price_end_date"]').value,
                qty: parseInt(row.querySelector('[name="qty"]').value),
                discount_per_item: parseFloat(row.querySelector('[name="discount_per_item"]').value),
                subtotal: sub
            });
        });

        fetch(`{{ route('transactions.store') }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': formData._token
            },
            body: JSON.stringify(formData)
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "{{ route('transactions.index') }}";
                });
            } else {
                throw new Error(data.message);
            }
        })
        .catch(err => {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: err.message || 'Terjadi kesalahan saat menyimpan data.'
            });
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = 'Simpan Transaksi <i class="fas fa-save ml-2"></i>';
        });
    });
});
</script>
@endsection