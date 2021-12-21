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
            <div class="card-header bg-primary">
                <div id="title" class="card-title">
                </div>
                <div id="sub_title" class="card-subtitle">
                </div>
            </div>
            <div id="card-body" class="card-body">
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div id="card_header_response" class="card-header bg-primary">
            </div>
            <div id="card_body_response" class="card-body">
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
                <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form" action="#">
                <div class="modal-body">
                    <div class=" form-group row">
                        <div class="col-12">
                            <textarea id="content" rows="3" name="content" class="form-control" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn_add_cancel" class="btn btn-secondary"
                        data-dismiss="modal">Batal</button>
                    <button type="submit" id="btn_add" class="btn btn-primary">Kirim</button>
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

    function showModal(type, data) {
        $('#exampleModalCenter').modal('show')
    }

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
        fetch('https://forum.temanjabar.net/api/question/{{$slug}}')
            .then(res => res.json())
            .then(res => {
                const data = res.data
                console.log(data)
                const created_at = new Date(data.created_at)
                $('#title').text(data.question)
                $('#sub_title').text(`${data.user.name} - ${created_at.getDate()} ${getMonthName(created_at.getMonth()+1)} ${created_at.getFullYear()} ${created_at.getHours()}:${created_at.getMinutes()}`)
                let html = "";
                if(data.image && data.image.length > 4) html += `<div>
                        <img class="card-img-top" style="max-height:300px;object-fit: contain;" src="https://forum.temanjabar.net/storage/questions/${data.image}" alt="${data.question}">`
                html += `<div class="card-text">${data.description}</div>`
                $('#card-body').html(html)
                const answers = data.answers
                if(answers.length > 0) {
                    let htmlAnswers = ""
                    answers.forEach(answer => {
                        const created_at_answer = new Date(answer.created_at)
                        htmlAnswers += `<div class="card-text">
                            <small><b>${answer.user?.name || '-'}</b> ${created_at_answer.getDate()} ${getMonthName(created_at_answer.getMonth()+1)} ${created_at_answer.getFullYear()} ${created_at_answer.getHours()}:${created_at_answer.getMinutes()}</small><br/> ${answer.content_answer}
                            </div>
                            <small>
                            <i class="fa fa-reply text-primary" style="cursor:pointer;" onclick="showModal('COMMENT',${data.id})"></i>
                            <span id="like_${answer.id}">${answer.comments.length} komentar</span>
                            </small>
                            <hr/>
                            `
                        answer.comments.forEach(comment => {
                        const created_at_comment = new Date(comment.created_at)
                            htmlAnswers += `<div class="card-text ml-3">
                                            <small><b>${comment.user?.name || '-'}</b> ${created_at_comment.getDate()} ${getMonthName(created_at_comment.getMonth()+1)} ${created_at_comment.getFullYear()} ${created_at_comment.getHours()}:${created_at_comment.getMinutes()}</small><br/> ${comment.content_comment}
                                        </div>
                                        <hr/>`
                        })
                    })
                    $('#card_body_response').append(htmlAnswers)
                }
                $('#card_header_response').html(`<button onclick="showModal('ANSWER',${data.id})" class="btn btn-sm btn-primary">Balas</button>`)
            })
            .catch(err => console.log(err));
    }

    $(document).ready(function () {
        render();

        $("#form_add").submit(function(e) {
            e.preventDefault();
            const form = $(this);
            const url = form.attr('action');

                    document.getElementById('form_add').reset()
                    $('#btn_add_cancel').trigger( "click" );
                    $('#image_add_preview').attr('src', imageCallback)
            // $.ajax({
            //     type: "POST",
            //     processData: false,
            //     contentType: false,
            //     url,
            //     data: new FormData(this),
            //     crossDomain: true,
            //     enctype: 'multipart/form-data',
            //     success: function(data)
            //     {
            //         render();
            //     }
            // });
        });
    });
</script>
@endsection
