<section class="m-auto w-3/4 mt-16">
    <h2 class="text-2xl font-bold text-stone-700 mb-4 w-5/6">Delete Event</h2>
    <form method="post" action="<?php echo URL . 'calendar/event/delete' ?>">
        <p class="p-4 mt-8 rounded-md bg-stone-100">Delete Event <strong><?php echo $event->getSummary(); ?></strong>?</p>
        <input type="hidden" value="<?php echo $event->id ?>" name="eventId" />
        <menu class="flex items-center justify-end gap-4 my-4">
            <li><button class="px-6 py-2 rounded-md bg-stone-800 text-stone-50 hover:bg-stone-950" type="submit">Delete Event</button></li>
            <li><a class="text-stone-800 hover:text-stone-950" href="<?php echo URL ?>">Cancel</a></li>
        </menu>
    </form>
</section>