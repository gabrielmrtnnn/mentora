@extends('layouts.app')

@section('content')

<div id="meet" class="rounded-3xl overflow-hidden" style="height:85vh">

</div>

<script>

    const api=new JitsiMeetExternalAPI(
    "meet.jit.si",
    {
        roomName:"{{ $booking->meeting_room }}",
        parentNode:
        document.querySelector('#meet'),
        width:"100%",
        height:"100%",
        userInfo:{
            displayName: "{{ auth()->user()->name }}"
        }
    });
</script>
@endsection