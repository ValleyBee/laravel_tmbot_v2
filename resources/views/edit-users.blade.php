@extends('layout')
@section('content')
    <form name="submit_one" action="{{route('users.update')}}" method="post">
        @csrf
        @method('put')
        <div class="form-group">
            <label name="tm_user_id ">
                <h4> TM USER ID : {{$user->botuser_id}} </h4>
            </label>
            <hr>

            ID:
            <b4 style="color:#800080"> {{$user->id}} </b4>
            <br>
            First name:
            <b4><em style="color:#800080">{{$userMsg->first_name}} </b4>
            </em><br>
            Last name:
            <b4><em style="color:#800080"> {{$userMsg->last_name}} </b4>
            </em><br>
            User created: <em style="color:#800080"> {{$user->created_at}} </em><br>
            User last message: <em style="color:#800080"> {{$userMsg->content}}</em><br>
            Message created: <em style="color:#800080"> {{$userMsg->created_at}}</em><br>
            Model type: <em style="color:#800080"> {{$user->model_type}}</em><br>
            Limit requests: <input type="number" min="0" name="limit_req_num" class="block w-full mt-1 rounded-md"
                                   style="background-color: #e3f2fd;" value="{{$user->limit_req_num}}"><br>
            Language: <em style="color:#800080"> {{$user->lang}}</em><br>

            {{-- <b style="border:1px solid #800080"> {{\App\Enums\Users\Status::cases()[$user->status_usr]->name}} </b> --}}
            Status:
            <select name="status" class="block w-full mt-1 rounded-md" style="background-color: #e3f2fd;">
                <option disabled selected> Select status</option>
                @foreach ($statuses as $status)

                    <option
                        value="{{ $status['id'] }}" {{$status['name'] == \App\Enums\Users\Status::cases()[$user->status_usr]->name ? 'selected' : ''}}> {{$status['name']}}
                    </option>
                @endforeach
            </select><br>
            Last AI reply: <em style="color:#1589FF"> {{$userMsg->reply_from_ai}}</em><br>
            <hr>
            <input type="email" class="form-group" id="email" name="email" placeholder="Enter your email">
            <input type="hidden" name="id" min="0" value="{{$user->id}}">
            <input type="hidden" name="lang" min="0" value="{{$user->lang}}">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary mr-2 mb-2 btn-sm">Update</button>
            <button formaction="{{route('sendmsg.sendMessageAuth')}}" type=" submit"
                    class="btn btn-primary mr-2 mb-2 btn-sm">SendUserAuth
            </button>
            <button formaction="{{route('sendmenu.sendMenu')}}" type=" submit" class="btn btn-primary mr-2 mb-2 btn-sm">
                SendUserMenu
            </button>
            <a href="{{route('showallusers.all') }}" type="button" class="btn btn-secondary mr-2 mb-2 btn-sm"
               name="submit">Back</a>
        </div>
    </form>

@endsection
