<div class="message-offcanvas">
    <div class="message-partner p-2">
        <div class="close-chat d-inline-block me-3" data-bs-dismiss="offcanvas" aria-label="Close">
            <span class="material-symbols-outlined">
            arrow_back_ios
            </span>
        </div>

        <a href="{{ route('users.show', $partner->id) }}">
            <div class="photo d-inline-block" style="background-image: url({{ $partner->getPhoto() }});"></div>
            <h4 class="name d-inline-block text-left mb-0">{{ $partner->username }}</h4>
        </a>
    </div>

    <div class="messages-container">
        @foreach($messages as $message)
            <div class="message {{ $message->from_id == Auth::id() ? 'from' : 'to' }} position-relative d-block p-2 my-2">
                @if($message->subject_type && $message->item_id)
                    <a href="{{$message->getURL($message->subject_type, $message->item_id)}}" class="message-subject m-0">{{$message->getItem($message->item_id)->title}}</a><br>
                @endif
                {{ $message->message }}<br>
                <p class="date m-0 text-end">{{ $message->created_at }}</p>
            </div>
        @endforeach
    </div>

    <form class="message-reply" id="message-reply">
        @csrf
        <div class="form-group p-0 text-center position-relative">
            <input type="hidden" name="to_id" id="to_id" value="{{ $partner->id }}">
            <textarea class="form-control input-dark w-100 d-inline-block" id="newMessage" name="message" rows="3" placeholder="Üzenet szövege..." required></textarea>
            <button class="btn btn-brand btn-send d-inline-block">
                <span class="material-symbols-outlined">
                send
                </span>
            </button>
        </div>
    </form>
</div>

<script>
    var offcanvas = $('.offcanvas-message');
    var partner = $('.message-partner');
    var messages = $('.messages-container');
    var reply = $('.message-reply');

    partner.width(offcanvas.width());
    messages.height(offcanvas.height() - reply.height() - partner.height() - 48);
    //messages.css('margin-top', partner.height() + 16);
    messages.scrollTop(messages.prop('scrollHeight'));
    reply.width(offcanvas.width()-32); 

    $(window).resize(function(){
        partner.width(offcanvas.width());
        messages.height(offcanvas.height() - reply.height() - partner.height() - 48);
        //messages.css('margin-top', partner.height() + 16);
        messages.scrollTop(messages.prop('scrollHeight'));
        reply.width(offcanvas.width());
    });

    $('#message-reply').on('submit', function(e){
        event.preventDefault();
        $.ajax({
            url: '{{ route('message-storeajax') }}' ,
            type: "POST",
            data:{
                "_token": "{{ csrf_token() }}",
                from_id: {{Auth::id()}},
                to_id: $('#to_id').val(),
                message: $('#newMessage').val(),
                is_read: 0
            },
            success: function( response ) {
                console.log(response);
                fetchNewMessage($('#to_id').val());
            }
        });
    });

    function fetchNewMessage(id){
        var messages = '/messages/'+id;
        $.get(messages, function (data) {
            $('.offcanvas').html(data);
        })
    }
</script>
