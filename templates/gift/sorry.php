<!-- Error Modal (for insufficient points) -->
<div id="errorModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeErrorModal()">×</span>
        <h2>Insufficient Points</h2>
        <p>You do not have enough points to purchase this gift.</p>
        <button onclick="closeErrorModal()">Close</button>
    </div>
</div>

<style>


        /* Modal Styles */
        .modal {
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 400px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    button {
        padding: 10px 20px;
        margin: 5px;
        cursor: pointer;
    }

</style>

<script>

function closeErrorModal() {
    window.location.href="<?$Url?>/gift";
}

</script>