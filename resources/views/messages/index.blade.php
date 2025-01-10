@extends('layouts.default')

@section('content')

    <h2 class="entity-title">Üzenetek</h2>

    @forelse($partners as $partner)
    <a href="{{ route('messages.show', $partner->id) }}" class="msgpartner id_{{$partner->id}} d-block w-100 p-2 mb-2 {{ Auth::user()->getLastInMessage($partner->id) ? '' : 'unread' }}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" onclick="setOffcanvas({{$partner->id}})">
        <div class="d-inline-block p-2">
            <div class="msg-photo d-inline-block" style="background-image: url({{ $partner->getPhoto() }});"></div>
        </div>

        <div class="d-inline-block p-2">
            <h4>{{ $partner->username }}</h4>
            <p class="lastMessage mb-0">{{ Auth::user()->getLastMessage($partner->id)->message }}</p>
            <p class="lastMessageDate">{{ Auth::user()->getLastMessage($partner->id)->created_at }}</p>
        </div>
    </a>
    @empty
    <p class="msgpartner d-block w-100 p-2 mb-2">Nem váltottál még üzenetet!</p>
    @endforelse

    <!-- Offcanvas -->
    <div class="offcanvas offcanvas-end offcanvas-message" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel"></div>

    <script type="text/javascript">
        function setOffcanvas(id){
            var messages = '/messages/'+id;
            $.get(messages, function (data) {
                $('.offcanvas').html(data);
                $('.msgpartner.id_'+id).removeClass('unread');
                
                if($('.msgpartner.unread').length == 0){
                    $('.notifications.badge').hide();
                    $('.dropdown-item .notifications.badge').hide();
                }
            });

            //refetch index
            $('.offcanvas-message')[0].addEventListener('hidden.bs.offcanvas', function () {
                var message = '/messages/sync/' + id;
                $.get(message, function (data) {
                    var message = JSON.parse(data).message;
                    var date = JSON.parse(data).created_at;

                    var dateObj = new Date(date);
                    var dateTime = dateObj.getFullYear()+'-'+dateObj.getMonth()+'-'+dateObj.getDate()+' '+dateObj.getHours()+':'+dateObj.getMinutes()+':'+dateObj.getSeconds();

                    console.log(dateTime);

                    $('.id_' + id + ' .lastMessage').html(message);
                    $('.id_' + id + ' .lastMessageDate').html(dateTime);
                })
            })
        }
    </script>

    @if (session('openChat'))
    <script type="text/javascript">
        function openChat(id){
            setOffcanvas(id);
            var myOffcanvas = document.getElementById('offcanvasRight');
            var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);
            bsOffcanvas.show();
        }

        openChat({{ session('openChat') }});
    </script>
    @endif
@stop
