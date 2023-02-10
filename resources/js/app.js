import './bootstrap';

// Import our custom CSS
import '../scss/styles.scss'

// Import all of Bootstrap's JS
import * as bootstrap from 'bootstrap'

document.getElementById("sample-form").addEventListener("submit", function (e) {
    if (e.preventDefault) e.preventDefault();

    submitOverride();
    return false;
});

let submitOverride = async function () {
    enableForm(false);
    showHideProgress(true);
    const uploadedFilePath = await uploadFile();

    document.getElementById("file-path").value = uploadedFilePath;

    enableForm(true);

    showHideProgress(false);
    updateProgress(0);
    document.getElementById("sample-form").submit();
}

let uploadFile = async function () {
    let fileInput = document.getElementById('file-input');
    let file = fileInput.files[0];
    
    // Get signed url to upload the file
    const response = await fetch('/sample/postupload/?filename=' + file.name);

    if (!response.ok) {
        const message = `An error has occured: ${response.status}`;
        throw new Error(message);
    }

    const result = await response.json();

    // Start uploading the file
    let formData = new FormData();
    Object.keys(result.inputs).forEach(key => {
        if (key != "key") {
            formData.append(key, result.inputs[key]);
        } else {
            formData.append("key", result.path);
        }
    });
    formData.append("file", file);

    await axios.post(result.attributes.action, formData, {
        onUploadProgress: progressEvent => {
            updateProgress(Math.round((progressEvent.loaded * 100) / progressEvent.total));
        }
        
    });
    
    return result.path;
}

let enableForm = function (enable) {
    if (enable === false) {
        document.getElementById("name-input").setAttribute("disabled", true);
        document.getElementById("check-input").setAttribute("disabled", true);
        document.getElementById("file-input").setAttribute("disabled", true);
        document.getElementById("submit-button").setAttribute("disabled", true);
    } else {
        document.getElementById("name-input").removeAttribute("disabled");
        document.getElementById("check-input").removeAttribute("disabled");
        document.getElementById("file-input").removeAttribute("disabled");
        document.getElementById("submit-button").removeAttribute("disabled");
    }
}

let showHideProgress = function (show) {
    if (show) {
        document.getElementById("form-progress").classList.remove("d-none");
    } else {
        document.getElementById("form-progress").classList.add("d-none");
    }
}


let updateProgress = function (value) {
    document.getElementById("form-progress-bar").style.width = `${value}%`;
}