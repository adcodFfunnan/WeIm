<!DOCTYPE html>
<html>
<head>
    <title>WeIm</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <style>
        .container
        {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            max-width: 65%;margin-top: 15px; 
        }

       
        body
        {
            background-color: #F8F8FF;
        }
         
            
            

    </style>





<body>
    <div class="container" style="background-color: #fff;">
       <h2>Add your images</h2> 
       <form method="POST"  action="{{url('uploadImages')}}" enctype="multipart/form-data">
        {{ csrf_field() }} 
        <div class="form-group">
            <table class="table" style="width:60%">
                <tr>
                    <td style="width:30%;"><input type="file" name="select_file[]" class="btn btn-info" multiple="multiple"/></td>
                    <td style="text-align:left"><small class="form-text text-muted text-muted">jpeg, png, jpg, gif</small></td>     
                </tr>

                <tr>
                    <td><input type="submit" name="upload" class="btn btn-info" value="UploadAsNew">
                        <input type="submit" name="upload" class="btn btn-success" value="AddToExisting"></td>
                        <input type="hidden" name="accessLink" value="{{ Session::get('accessLink') }}">
                   <td></td>
                </tr>
            </table>
        </div>          
       </form>
       <div class="form-group">
                        <label>AccessLink</label>
                            <table>
                                <tr> 
                                <form method="GET"  action="{{ url('accessWithLink') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <td>
                                        <input  class="form-control" autocomplete="off" name="accessLink" 
                                        value="{{ Session::get('accessLink') }}" placeholder="Enter acces code"></td>
                                        <td>
                                            <input type="submit" class="btn btn-info" style="margin-left: 5px;"></td>
                                </form>
                                    <td>
                                    @if(Session::get('processingTime'))

                                    @php $time=number_format(Session::get('processingTime'),2); @endphp

                                        <div style="background-color:#F8F8FF; position:relative;left:10px;">
                                        <small class="form-text text-muted">Your images are uploaded in: {{ $time }} sec</small>
                                    </div>
                                    @endif

                                    @if(Session::get('validationFails'))
                                    <div style="background-color:#F8F8FF;position:relative;left:10px;border:1px solid #cc8080;padding: 3px;">
                                    <small class="form-text text-muted">Validation of your request has failed ...
                                    <br>No proper image file or misuse of add functionality</small>
                                    @endif

                                </td>


                                </tr>
                                <tr><td><small class="form-text text-muted">You can use the passcode to access your images.</small></td></tr>

                            </table>          
        </div>
    </div>


    <div class="container-fluid" style="margin-top:15px;">
        @if(Session::get('links'))  

        <table class="table table-bordered">
           
               @php {{ $i=1; }} @endphp
                @while($i<=count(Session::get('links')))

                  <tr>

                    @if(($i-1)==count(Session::get('links'))) @break @endif
                    <td width="20%">
                    <img src="{{ Session::get('links')[$i-1] }}"
                    width="100%" height="200px">
                    <form method="POST" action="{{ url('deleteImages') }}" enctype="multipart/form-data">
                         {{ csrf_field() }}
                    <input type="hidden" name="ImgForDel" value="{{ Session::get('links')[$i-1] }}">
                    <input type="hidden" name="accessLink" value="{{ Session::get('accessLink') }}">
                    <button type="submit" class="btn btn-danger" style="position:relative;top:4px;float:right;">Delete</button></td>
                </form>
 
 

                    @if($i==count(Session::get('links'))) @break @endif
                    <td width="20%">
                    <img src="{{ Session::get('links')[$i] }}"
                    width="100%" height="200px">
                    <form method="POST" action="{{ url('deleteImages') }}" enctype="multipart/form-data">
                         {{ csrf_field() }}
                    <input type="hidden" name="ImgForDel" value="{{ Session::get('links')[$i] }}">
                    <input type="hidden" name="accessLink" value="{{ Session::get('accessLink') }}">
                    <button type="submit" class="btn btn-danger" style="position:relative;top:4px;float:right;">Delete</button></td></form>

                    @if(($i+1)==count(Session::get('links'))) @break @endif
                    <td width="20%">
                    <img src="{{ Session::get('links')[$i+1] }}" width="100%" height="200px">
                    <form method="POST" action="{{ url('deleteImages') }}" enctype="multipart/form-data">
                         {{ csrf_field() }}
                    <input type="hidden" name="ImgForDel" value="{{ Session::get('links')[$i+1] }}">
                     <input type="hidden" name="accessLink" value="{{ Session::get('accessLink') }}">
                    <button type="submit" class="btn btn-danger" style="position:relative;top:4px;float:right;">Delete</button></td></form>

                    @if(($i+2)==count(Session::get('links'))) @break @endif
                     <td width="20%" ><img src="{{ Session::get('links')[$i+2] }}"
                    width="100%" height="200px">
                    <form method="POST" action="{{ url('deleteImages') }}" enctype="multipart/form-data">
                         {{ csrf_field() }}
                    <input type="hidden" name="ImgForDel" value="{{ Session::get('links')[$i+2] }}">
                    <input type="hidden" name="accessLink" value="{{ Session::get('accessLink') }}">
                    <button type="submit" class="btn btn-danger" style="position:relative;top:4px;float:right;">Delete</button></td>
                    </form>

                    @php {{ $i=$i+4; }} @endphp
                  
                 </tr>

                 @endwhile   
               
            
         </table>
    </div>      
        @endif
    </div>

</body>
</html>