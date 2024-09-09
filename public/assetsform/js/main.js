

const signatureCanvas = document.getElementById('signature');
const clearSignatureBtn = document.getElementById('clear-signature');

let isDrawing = false;
let context = signatureCanvas.getContext('2d');
let startX, startY;

context.lineWidth = 2;
context.lineCap = 'round';
context.strokeStyle = '#000';

signatureCanvas.addEventListener('mousedown', (e) => {
    isDrawing = true;
    startX = e.offsetX;
    startY = e.offsetY;
});

signatureCanvas.addEventListener('mousemove', (e) => {
    if (isDrawing) {
        context.beginPath();
        context.moveTo(startX, startY);
        context.lineTo(e.offsetX, e.offsetY);
        context.stroke();

        startX = e.offsetX;
        startY = e.offsetY;
    }
});

signatureCanvas.addEventListener('mouseup', () => {
    isDrawing = false;
});

clearSignatureBtn.addEventListener('click', () => {
    context.clearRect(0, 0, signatureCanvas.width, signatureCanvas.height);
});


 Webcam.set({
        width: 490,
        height: 350,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
    
    Webcam.attach( '#my_camera' );
    
    function take_snapshot() {
        Webcam.snap(function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
        });
    }

   $(document).ready(function () {
      // Handle click on table row in modal
      $('.tujuan-row').click(function () {
         var idAkun = $(this).data('id');
         var namaAkun = $(this).data('nama');

         // Set values in the main input and hidden input
         $('#tujuan').val(namaAkun);
         $('#id_akun').val(idAkun);

         // Close the modal
         $('#tujuanModal').modal('hide');
      });
   });

   

