document.addEventListener('DOMContentLoaded', function(){
    // modal whatever fill
    const pageQuestionModal = document.getElementById('getPageQuestionModal')
    if (pageQuestionModal) {
        pageQuestionModal.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget
            // Extract info from data-bs-* attributes
            const recipient = button.getAttribute('data-bs-whatever')
            // If necessary, you could initiate an Ajax request here
            // and then do the updating in a callback.

            // Update the modal's content.
            const modalBodyInput = pageQuestionModal.querySelector('#title-modal')
            modalBodyInput.value = recipient
        })
    }
});
