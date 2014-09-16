<?php foreach ($printJob['documents'] as $index => $document): ?>
    <div class="">
        <h2><?php echo $document['file_name']; ?></h2>

        <a href="?job_id=<?php echo $jobId; ?>&action=open_document&$index=<?php echo $index; ?>">
            Open Document
        </a> |
        <a href="?job_id=<?php echo $jobId; ?>&action=print_document&$index=<?php echo $index; ?>"
           onclick="return alert('This feature is not available at the moment!!');">
            Print Document
        </a>
    </div>
<?php endforeach; ?>