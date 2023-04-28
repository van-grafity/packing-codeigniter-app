<?= $this->extend('app-layout/template'); ?>

<?= $this->Section('content'); ?>
<div class="content-wrapper">
    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?= $title ?></h3>
            </div>
            <div class="card-body">
                <a href="/style/create" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-default">Add Style</a>
                <table class="table table-bordered table-hover" id="myTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Style No</th>
                            <th>Style Description</th>
                            <th>Style GL</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($styles as $style) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $style['style_no']; ?></td>
                                <td><?= $style['style_description']; ?></td>
                                <td><?= $style['gl_number']; ?></td>
                                <td>
                                    <a href="/style/edit/<?= $style['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="/style/<?= $style['id']; ?>" method="post" class="d-inline">
                                        <?= csrf_field(); ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" onclick="return confirm('Are you sure?');" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection(); ?>