const forms = [{
        nama: "Pemasangan Utilitas",
        kode: "PU",
        forms: [{
                label: "Surat permohonan diatas Kop Surat ditunjukan kepada Kepala Dinas PMPTSP Prov. Jawa Barat (Kop surat asli, tandatangan asli bukan scan/palsu serta cap/stempel asli bukan scan)",
                type: "file",
                kode: 1
            },
            {
                label: "Surat Kuasa memakai kop surat diatas materai apabila dikuasakan (kop surat asli, tandatangan asli bukan scan, cap/stempel asli bukn scan)",
                type: "file",
                kode: 2
            },
            {
                label: "Fotocopy KTP Permohonan",
                type: "file",
                kode: 3
            },
            {
                label: "NIK",
                type: "number",
                kode: 31
            },
            {
                label: "Nama",
                type: "text",
                kode: 32
            },
            {
                label: "Alamat",
                type: "text",
                kode: 33
            },
            {
                label: "Fotocopy KTP yang dikuasakan",
                type: "file",
                kode: 4
            },
            {
                label: "NIK",
                type: "number",
                kode: 41
            },
            {
                label: "Nama",
                type: "text",
                kode: 42
            },
            {
                label: "Alamat",
                type: "text",
                kode: 43
            },
            {
                label: "Fotocopy Akte Pendirian Persuahaan sesuai dengan nama di permohonan (apabila pemohon perusahaan)/ Copy KTP untuk Perorangan",
                type: "file",
                kode: 5
            },
            {
                label: "Surat Pernyataan Kesanggupan survey lapangan",
                type: "file",
                kode: 6
            },
            {
                label: "Jadwal pelaksanaan pekerjaan",
                type: "file",
                kode: 7
            },
            {
                label: "Surat Pernyataan bersedia memberikan jaminan bank garansi",
                type: "file",
                kode: 8
            },
            {
                label: "Surat Pernyataan Pemakaian Tanah Negara bermaterai Rp. 6000",
                type: "file",
                kode: 9
            },
        ]
    },
    {
        nama: "Jalan Masuk",
        kode: "JM",
        forms: [{
                label: "Surat permohonan diatas Kop Surat ditunjukan kepada Kepala Dinas PMPTSP Prov. Jawa Barat (Kop surat asli, tandatangan asli bukan scan/palsu serta cap/stempel asli bukan scan)",
                type: "file",
                kode: 1
            },
            {
                label: "Surat Kuasa memakai kop surat diatas materai apabila dikuasakan (kop surat asli, tandatangan asli bukan scan, cap/stempel asli bukn scan)",
                type: "file",
                kode: 2
            },
            {
                label: "Fotocopy KTP Permohonan",
                type: "file",
                kode: 3
            },
            {
                label: "NIK",
                type: "number",
                kode: 31
            },
            {
                label: "Nama",
                type: "text",
                kode: 32
            },
            {
                label: "Alamat",
                type: "text",
                kode: 33
            },
            {
                label: "Fotocopy KTP yang dikuasakan",
                type: "file",
                kode: 4
            },
            {
                label: "NIK",
                type: "number",
                kode: 41
            },
            {
                label: "Nama",
                type: "text",
                kode: 42
            },
            {
                label: "Alamat",
                type: "text",
                kode: 43
            },
            {
                label: "Fotocopy Akte Pendirian Persuahaan sesuai dengan nama di permohonan (apabila pemohon perusahaan)/ Copy KTP untuk Perorangan",
                type: "file",
                kode: 5
            },
            {
                label: "Surat Pernyataan Kesanggupan survey lapangan",
                type: "file",
                kode: 6
            },
            {
                label: "Gambar Situasi",
                type: "file",
                kode: 7
            },
            {
                label: "Surat pernyataan Pemakaian Tanah Negara bermaterai Rp. 10.000 (6000 + 6000 atau 6000 + 3000)",
                type: "file",
                kode: 8
            },
        ]
    },
    {
        nama: "Pemasangan Reklame",
        kode: "PR",
        forms: [{
                label: "Surat pernyataan Pemakaian Tanah Negara bermaterai Rp. 6.000",
                type: "file",
                kode: 1
            },
            {
                label: "Surat Pernyataan Kesanggupan survey lapangan",
                type: "file",
                kode: 2
            },
            {
                label: "Surat Kuasa memakai kop surat diatas materai apabila dikuasakan (kop surat asli, tandatangan asli bukan scan, cap/stempel asli bukn scan)",
                type: "file",
                kode: 3
            },
            {
                label: "Fotocopy KTP Permohonan",
                type: "file",
                kode: 4
            },
            {
                label: "NIK",
                type: "number",
                kode: 41
            },
            {
                label: "Nama",
                type: "text",
                kode: 42
            },
            {
                label: "Alamat",
                type: "text",
                kode: 43
            },
            {
                label: "Fotocopy KTP yang dikuasakan",
                type: "file",
                kode: 5
            },
            {
                label: "NIK",
                type: "number",
                kode: 51
            },
            {
                label: "Nama",
                type: "text",
                kode: 52
            },
            {
                label: "Alamat",
                type: "text",
                kode: 53
            },
            {
                label: "Fotocopy Akte Pendirian Persuahaan sesuai dengan nama di permohonan(apabila pemohon perusahaan) / Copy KTP untuk Perorangan",
                type: "file",
                kode: 6
            },
            {
                label: "Gambar Rencana Konstruksi",
                type: "file",
                kode: 7
            },
        ]
    },
]

document.addEventListener('DOMContentLoaded', () => {
            const { persyaratan } = data || { persyaratan: null };
            console.log(JSON.parse(persyaratan), storageURL);
            const persyaratanParse = JSON.parse(persyaratan)
            const renderPersyaratan = () => {
                    const persyaratanContainer = document.getElementById('persyaratan_container');
                    const { value: tipePermohonan } = document.getElementById('tipe_permohonan');
                    const selectedPersyaratanForm = forms.find(form => form.kode === tipePermohonan);
                    document.getElementById('selectedPersyaratanForm').value = JSON.stringify(selectedPersyaratanForm);

                    let htmlPersyaratan = selectedPersyaratanForm.forms.map(form => {
                                return `<div class="form-group row">
            <label class="col-md-${form.type === 'file' ? 9 : 3} col-form-label">${form.label}</label>
            <div class="col-md-${form.type === 'file' ? action === 'update' ? 2 : 3 : 9} row">
                    <input name="${selectedPersyaratanForm.kode}_${form.kode}" type="${form.type}"
                        class="form-control" >
            </div>
            ${form.type === 'file' && action === 'update' ? persyaratan ? persyaratanParse[`${selectedPersyaratanForm.kode}_${form.kode}`] ? `<div class="col-md-1">
                <a href="${storageURL}/${persyaratanParse[`${selectedPersyaratanForm.kode}_${form.kode}`]}" target="_blank" class="btn btn-primary"><i class="fas fa-share-square"></i></a>
            </div>` : '' : '' : ''}
            </div>`
        });

        // required
        persyaratanContainer.innerHTML = htmlPersyaratan.join('');
    }

    const tipePermohonanSelect = document.getElementById('tipe_permohonan');
    tipePermohonanSelect.onchange = () => renderPersyaratan();
    renderPersyaratan();

})