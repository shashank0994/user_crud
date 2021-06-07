<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $name,$email,$avatar,$joining_date,$leaving_date,$still_working;
    public $users_count,$search_string,$createUserModel,$userId = '';

    protected $listeners = [
      'selfRefresh'=>'$refresh'
    ];

    public function mount(){
        $this->createUserModel = false;
        $this->still_working = true;
    }

    public function render()
    {
        $this->users_count = User::count();
        if($this->search_string==''){
            $users=User::orderBy('name','asc');
        }else{
            $this->resetPage();
            $users=User::where('name','like','%'.$this->search_string.'%');
        }
        $users=$users->paginate(15);
        return view('livewire.users.user-list',compact('users'));
    }

    public function createUser() {
        $this->createUserModel = true;
        $this->resetErrorBag();
        $this->resetValidation();
        $this->email = '';
        $this->name = '';
        $this->joining_date = '';
        $this->leaving_date = '';
        $this->still_working = true;
    }

    public function saveUser(){
        $user_data = $this->validate([
           'email'=>'required|email|unique:users,email',
           'name'=>'required|string|max:250',
           'joining_date'=>'required|date_format:Y-m-d',
           'leaving_date'=>"required_if:still_working,false",
           'still_working'=>'nullable',
           'avatar'=>'nullable|image|max:1024'
        ]);

        $user_data['joining_date'] = Carbon::createFromFormat('Y-m-d',$user_data['joining_date']);

        $user_data['leaving_date'] = !$user_data['still_working'] ? Carbon::createFromFormat('Y-m-d',$user_data['leaving_date']) : Carbon::now();
        if(is_null($user_data['avatar'])){
            $user_data['avatar'] = $this->storeAvatar($user_data['name']);
        }else{
            $user_data['avatar'] = $this->avatar->store('avatars');
        }

        User::create($user_data);
        $this->createUserModel = false;
        session()->flash('success','User record is successfully created');
        $this->emitSelf('selfRefresh');
    }

    public function storeAvatar($name){
        $image=file_get_contents('https://ui-avatars.com/api/?name='.urlencode($name).'&color=ffffff&background=374151');
        $file_name='avatars/'.Carbon::now()->timestamp.'.png';
        $stored=Storage::disk('public')->put($file_name,$image);
        if($stored){
            return $file_name;
        }else{
            return '';
        }
    }

    public function DeleteUser(){
        $user = User::find(decrypt($this->userId));
        if($user){
            $user->delete();
            session()->flash('success','User record deleted successfully');
        }
        $this->userId = '';
        $this->emitSelf('selfRefresh');
    }
}
