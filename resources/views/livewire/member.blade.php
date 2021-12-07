<div>

    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

   

    <hr>

    <div class="row">
        <div class="col">
            <select wire:model="paginate" name="" id="" class="form-control-form-control sm w-auto">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="15">20</option>
            </select>
        </div>
        <div class="md-3">
        <label for="from" class="tw-font-bold ml-3">From</label>
                <input  wire:key="4" type="date" wire:change="$emit('changeDateValue')"   max="{{$maxDate}}" wire:model.defer="startDate"  id="from"
                    class="form-control form-control-sm mx-sm-3" style="border-bottom: 1px solid rgb(123, 128, 154); border-radius: 0px !important;">
                    
                <label for="to" class="tw-font-bold">To</label>
                <input  wire:key="5" type="date"   wire:model.defer="endDate" min="{{$minDate}}" max="{{$maxDate}}" id="to" 
                               class="form-control form-control-sm mx-sm-3" style="border-bottom: 1px solid rgb(123, 128, 154); border-radius: 0px !important;">
                <button  type="button" wire:click.prevent="search"
                   class="btn btn-info btn-sm mr-1 text-white btn-sm tw-mt-3">Search</button>
                </div>
                   <div class="col">
            <input wire:model="search" type="text" class="form-control form-control-sm" placeholder="Search">
        </div>
    </div>
  
    <hr>

   <table class="table table-bordered table-striped">
       <thead class="thead-dark">
           <tr>
               <th scope="col">#</th>
               <th scope="col">Name</th>
               <th scope="col">Email</th>
               <th scope="col">Active</th> 
               <th scope="col">Time</th>
               <th scope="col">Aksi</th>
           </tr>
       </thead>
       <tbody>
           <?php $no =1; ?>
           @foreach ($member as $member)
           <tr>
               <th scope="row">{{$no++}}</th>
               <td>{{$member->name}}</td>
               <td>{{$member->email}}</td>
               <td>{{$member->active}}</td>
               <td>{{$member->created_at}}</td>
               <td>
                   <button wire:click="getMember({{$member->id}})" class="btn btn-sm btn-info text-white">Edit</button>
                   <button wire:click="destroy({{$member->id}})" class="btn btn-sm btn-danger text-white">Delete</button>
                </td>
            </tr>
            @endforeach
       </tbody>
   </table>
 
</div>
<script type="text/javascript">
     $(document).ready( function () {
        let from = document.querySelector('#from');
        let to = document.querySelector('#to');
        from.value = new Date().toISOString().split('T')[0]
        to.value = new Date().toISOString().split('T')[0]
        from.dispatchEvent(new Event('input'))
        to.dispatchEvent(new Event('input'))

    })
</script>
<script>
// Change Max Date on the html dom by directly listen the event 
window.addEventListener('changeDateValue', event => {
    document.getElementById("to").setAttribute("max", event.detail.maxDate);
    document.getElementById("from").setAttribute("max", event.detail.maxDate);

    document.getElementById("to").setAttribute("min", event.detail.minDate);
    // document.getElementById("from").setAttribute("min", event.detail.minDate);
})
</script>