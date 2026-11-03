{{-- <div
    class="modal fade"
    id="deleteModal"
    tabindex="-1"
    aria-labelledby="deleteModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    Delete
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>

            <div class="modal-body">

                <p class="mb-1">
                    Are you sure you want to delete
                    <strong id="deleteItemName"></strong>?
                </p>

                <small class="text-muted">
                    This action cannot be undone.
                </small>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>

                <form
                    id="deleteForm"
                    method="POST"
                >
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-danger"
                    >
                        Delete
                    </button>
                </form>

            </div>

        </div>

    </div>
</div> --}}
<div
    class="modal fade"
    id="deleteModal"
    tabindex="-1"
    aria-hidden="true"
>
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Confirm Delete
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>

            <form
                method="POST"
                id="deleteForm"
            >

                @csrf
                @method('DELETE')

                <div class="modal-body">

                    <p>
                        Are you sure you want to delete
                        <strong id="deleteItemName"></strong>?
                    </p>

                    <div
                        id="deletePetsWarning"
                        class="alert alert-warning d-none"
                    >
                        <i class="bi bi-exclamation-triangle me-2"></i>

                        This customer has
                        <strong id="deletePetsCount"></strong>
                        pet(s).

                        Deleting this customer will also delete
                        all associated pets.

                    </div>

                    <p class="text-muted mb-0">
                        This action cannot be undone.
                    </p>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-danger"
                    >
                        Delete
                    </button>

                </div>

            </form>

        </div>

    </div>
</div>