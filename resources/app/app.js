document.querySelector('button.accountDataSubmit').addEventListener('click', () => {
    
    const newAccData = document.querySelector('#createForm').value;
    
    axios.post(uriPath+'api/create/', {
        newAccData: newAccData;    
    })
    .then (function (response) {
        console.log(response);
    })
    .catch(function (error) {
        console.log(error);
    });
    console.log('paspausta');
});




console.log('test test');