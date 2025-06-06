<select name="ciudad" id="select_ciudades" class="form-control">
    @foreach($ciudades as $ciudade)
        <option value="{{$ciudade->id}}">{{$ciudade->name}}</option>
    @endforeach
</select>
