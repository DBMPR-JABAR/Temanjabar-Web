@extends('admin.layout.index')

@section('title') Admin Dashboard @endsection
@section('head')
<link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}">
@endsection

@section('page-header')
<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Forum</h4>
                <span>Tanya jawab seputar Teman Jabar</span>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class=" breadcrumb breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="{{ url('admin') }}"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Forum</a> </li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('page-body')

<div class="row">
    <div class="col-md-12">

        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                    Tambah
                </button>
            </div>
            <div class="card-block row">

                {{-- START LIST --}}
                <div class="col-12">
                    <ul id="topic_list" class="row">

                    </ul>
                </div>
                {{-- END LIST --}}
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Tambah Pertanyaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_add" action="https://forum.temanjabar.net/api/store/question/teman-jabar/{{$idUser}}"
                enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-12">
                            <img style="min-height: 40px" class="mx-auto rounded img-thumbnail d-block"
                                id="image_add_preview" src="{{asset('assets\images\sample\sample.png')}}" alt="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label">Gambar</label>
                        <div class="col-md-8">
                            <input id="image_add" name="image" type="file" accept="image/*" class="form-control">
                        </div>
                    </div>
                    <div class=" form-group row">
                        <label class="col-md-4 col-form-label">Pertanyaan</label>
                        <div class="col-md-8">
                            <input id="question_add" required name="question" value="" type="text" class="form-control">
                        </div>
                    </div>
                    <div class=" form-group row">
                        <label class="col-md-4 col-form-label">Deskripsi</label>
                        <div class="col-md-8">
                            <textarea id="description_add" rows="3" name="description" class="form-control"
                                required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_add_cancel" class="btn btn-secondary"
                        data-dismiss="modal">Batal</button>
                    <button type="submit" id="btn_add" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    const frameAddUrl = 'http://124.81.122.131/forum/public/ex/question/create/teman-jabar/$id_user'
    const addUrl = 'http://124.81.122.131/forum/public//store/question/teman-jabar/$id_user'
    const imageCallback = "{{asset('assets/images/sample/sample.png')}}"
    const baseUrl = "{{url('/')}}"

    const getMonthName = (month) => {
        switch (month) {
            case 1:
                return 'Januari'
            case 2:
                return 'Februari'
            case 3:
                return 'Maret'
            case 4:
                return 'April'
            case 5:
                return 'Mei'
            case 6:
                return 'Juni'
            case 7:
                return 'Juli'
            case 8:
                return 'Agustus'
            case 9:
                return 'September'
            case 10:
                return 'Oktober'
            case 11:
                return 'November'
            case 12:
                return 'Desember'
        }
    }

    const render = () => {
        $('#topic_list').empty()
        fetch('https://forum.temanjabar.net/api/category/teman-jabar')
            .then(res => res.json())
            .then(res => {
                console.log(res);
                res.data.forEach(element => {
                    let html = "";
                    let createdAt = new Date(element.created_at)
                    let createdAtWithMonthName = createdAt.getDate() + " " + getMonthName(createdAt.getMonth()+1) + " " +
                        createdAt.getFullYear()


                    html += `<div class="col-md-6 d-flex align-items-stretch">
                                <div class="card w-100">
                                    <div class="card-header bg-primary p-2">
                                        <div class="card-title p-0">
                                            ${element.question}
                                        </div>
                                        <div class="card-subtitle p-0">
                                                <small>oleh ${element.user.name} pada ${createdAtWithMonthName}</small>
                                        </div>
                                    </div>`
                    if(element.image && element.image.length > 4) html += `<div class="px-3 pt-3 pb-0">
                        <img class="card-img-top" style="max-height:200px;object-fit: contain;" src="https://forum.temanjabar.net/storage/questions/${element.image}" alt="${element.question}">
                        </div>`
                    html +=`<div class="card-body p-2">
                                    <p class="card-text">${element.description || '-'}</p>
                            </div>
                            <div class="card-footer p-2">
                                <a href="${baseUrl}/admin/forum/${element.slug}" class="btn btn-sm btn-primary">Selengkapnya..</a>
                            </div>
                            </div>
                            </div>`
                    $('#topic_list').append(html);
                });
            })
            .catch(err => console.log(err));
    }

    $(document).ready(function () {
        render();
        const filePreviews = [
            {
                input:"image_add",
                preview:"image_add_preview"
            }
        ]

        filePreviews.forEach(data=> {
            const inputElement = document.getElementById(data.input)
            inputElement.onchange = event => {
                const [file] = inputElement.files
                if(file) document.getElementById(data.preview).src = URL.createObjectURL(file)
                }
        })

        $("#form_add").submit(function(e) {
            e.preventDefault();
            const form = $(this);
            const url = form.attr('action');

            $.ajax({
                type: "POST",
                processData: false,
                contentType: false,
                url,
                data: new FormData(this),
                crossDomain: true,
                enctype: 'multipart/form-data',
                success: function(data)
                {
                    document.getElementById('form_add').reset()
                    $('#btn_add_cancel').trigger( "click" );
                    $('#image_add_preview').attr('src', imageCallback)
                    render();
                }
            });
        });

    });
</script>
@endsection
