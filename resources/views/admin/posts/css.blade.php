@section('css')
<style type="text/css">
.images{
    border: 1px solid #ccc;
    text-align: center;
}

.image-item{
    margin-top: 15px;
    display: inline-block;
    margin-bottom: 15px;
    border: 1px solid #eee;
    margin-right: 15px;
    height: 100px;
}

.image-item > img{
  width: 100%;
}

.uploads_box{
    width: 20%;
    display: inline-block;
    margin: 15px
    
}

#success_image_box{
    display:flex;
    flex-wrap: wrap;
}
#success_image_box .dz-preview {
    position: relative;
}
#success_image_box .dz-preview img{
    width:100%;
    height:auto;
}

#success_image_box .dz-preview .zhezhao{
    position: absolute;
    bottom: 0;
    top: 0;
    right: 0;
    left: 0;
    background-color: rgba(0, 0, 0, 0.4);
    z-index: 100;
    height: 100%;
    width: 100%;
}

#success_image_box .dz-preview .dz-progress {
    position: absolute;
    left: 50%;
    top: 50%;
    -webkit-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    -webkit-transition: all 2.5s;
    transition: all 2.5s;
    z-index: 100;
    color: red;
}

</style>
@endsection