<x-modal-confirm
    event-to-open-modal="custom-show-mark-idea-as-Not-spam-modal"
    event-to-close-modal="ideaWasMarkedAsNotSpam"
    modal-title="Mark Idea As Not Spam? This will reset the spam counter to 0"
    modal-description="Are you sure you want to mark this idea as not spam?"
    modal-confirm-button-text="Mark as Not Spam"
    wire-click="markAsNotSpam"
/>
