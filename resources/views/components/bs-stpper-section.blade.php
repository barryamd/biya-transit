<div class="bs-stepper">
    <div class="bs-stepper-header" role="tablist">
        <!-- your steps here -->
        <div class="step" data-target="#nom1-part">
            <button type="button" class="step-trigger" role="tab" aria-controls="nom1-part" id="nom1-part-trigger">
                <span class="bs-stepper-circle">1</span>
                <span class="bs-stepper-label">Title 1</span>
            </button>
        </div>
        <div class="line"></div>
        <div class="step" data-target="#nom2-part">
            <button type="button" class="step-trigger" role="tab" aria-controls="nom2-part" id="nom2-part-trigger">
                <span class="bs-stepper-circle">2</span>
                <span class="bs-stepper-label">Title 2</span>
            </button>
        </div>
    </div>
    <div class="bs-stepper-content">
        <!-- your steps content here -->
        <div id="nom1-part" class="content" role="tabpanel" aria-labelledby="nom1-part-trigger">
            Content 1
            <button class="btn btn-primary" onclick="stepper.next()">Next</button>
        </div>
        <div id="nom2-part" class="content" role="tabpanel" aria-labelledby="nom2-part-trigger">
            Content 2
            <button class="btn btn-primary" onclick="stepper.previous()">Previous</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</div>
