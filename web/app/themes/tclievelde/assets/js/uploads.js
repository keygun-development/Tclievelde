window.onload = function () {
    const profielfoto = document.getElementById('profielfoto');
    const errormsg = document.getElementById('errormsg');
    const image = document.getElementById('selectedimage');
    profielfoto.addEventListener('change', (event) => {
        const file = profielfoto.files[0];
        if (file.type == 'image/jpeg' || file.type == 'image/png') {
            const filesize = file.size / 1024 / 1024;

            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function (e) {
                image.src = e.target.result
                errormsg.innerText = '';
            }
            if (filesize >= 5) {
                errormsg.innerText = "Image is: "+filesize+" Mib, dit is te groot crop de image of gebruik een andere.";
                image.src = '';
            }
        } else {
            errormsg.innerText = "Sorry, maar type: "+file.type+" wordt niet ondersteund.";
            image.src = '';
        }
    })
}