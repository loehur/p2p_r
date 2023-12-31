<header class="py-1 mb-2 bg-gradient-primary-to-secondary">
    <div class="container-xl">
        <div class="text-center">
            <h1 class="text-white"><?= $data['_c'] ?></h1>
        </div>
    </div>
</header>

<!-- Main page content-->
<div class="row mx-1">
    <div class="col py-1 px-1 bg-white">
        <?php foreach ($data['user'] as $du) { ?>
            <div class="row border mx-1 mb-1 rounded border">
                <div class="col text-nowrap">
                    <?= $du['nama'] ?>
                    <br>
                    <?= $this->model("M_DB_1")->get_cols_where("_bank", "name", "code = '" . $du['bank'] . "'", 0)['name'] ?>
                    <br>
                    <?= $du['rekening'] ?>
                </div>
                <div class="col">
                    <a href="#" data-id="<?= $du['user'] ?>" class="text-success verifyData">Verify</a>
                    <a href="#" class="text-danger reject_ float-end mt-auto" data-id="<?= $du['user'] ?>" data-bs-target="#modal_reject" data-bs-toggle="modal">Reject</a>
                </div>
            </div>
        <?php } ?>
    </div>

    <form action="<?= $this->BASE_URL . $data['_c'] ?>/reject" method="POST">
        <div class="modal" id="modal_reject">
            <div class="modal-dialog">
                <div class="modal-content bg-danger-soft">
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col">
                                <label class="form-label">Alasan Reject</label>
                                <input type="text" name="alasan" class="form-control" required />
                                <input type="hidden" name="user_reject" class="form-control" />
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <button type="submit" data-bs-dismiss="modal" class="btn btn-danger">Reject</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="<?= $this->ASSETS_URL ?>js/jquery-3.7.0.min.js"></script>

<script>
    $("form").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: $(this).attr("method"),
            success: function(res) {
                if (res == 0) {
                    content();
                } else {
                    alert(res);
                }
            }
        });
    });

    $("a.cek_").click(function() {
        var user = $(this).attr("data-id");
        $("div#cek").load("<?= $this->BASE_URL . $data['_c'] ?>/cek/" + user);
    })

    $("a.reject_").click(function() {
        var user = $(this).attr("data-id");
        $("input[name=user_reject]").val(user);
    })


    $("a.verifyData").click(function() {
        var user = $(this).attr("data-id");
        if (confirm("Yakin Memverifikasi " + user + "?")) {
            var id = $(this).attr("data-id");
            $.ajax({
                url: "<?= $this->BASE_URL . $data['_c']  ?>/verify",
                data: {
                    user: user
                },
                type: "POST",
                success: function(res) {
                    if (res == 0) {
                        content();
                    } else {
                        alert(res);
                    }
                },
            });
        } else {
            return false;
        }
    })
</script>