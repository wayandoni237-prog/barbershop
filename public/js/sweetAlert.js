    function confirmDelete(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "Delete this data?",
            icon: "question",
            showCancelButton:true,
            cancelButtonText: "Cancel",
            confirmButtonColor: "#dc3545",
            cancelButtonColor: "#6c757d", 
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }


        function confirmInactive(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "Inactive this service?",
            icon: "question",
            showCancelButton:true,
            cancelButtonText: "Cancel",
            confirmButtonColor: "#dc3545",
            cancelButtonColor: "#6c757d", 
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('inactive-form-' + id).submit();
            }
        });
    }


        function confirmActive(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "Change this service to active ?",
            icon: "question",
            showCancelButton:true,
            cancelButtonText: "Cancel",
            confirmButtonColor: "#dc3545",
            cancelButtonColor: "#6c757d", 
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('active-form-' + id).submit();
            }
        });
    }

        function confirmReject(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "Reject this booking ?",
            icon: "question",
            showCancelButton:true,
            cancelButtonText: "Cancel",
            confirmButtonColor: "#dc3545",
            cancelButtonColor: "#6c757d", 
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('reject-form-' + id).submit();
            }
        });
    }