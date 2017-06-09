export class Venue {
    constructor(
        public venueId: number,
        public venueImageId: number,
        public venueActivationToken: string,
        public venueAddress1: string,
        public venueAddress2: string,
        public venueCity: string,
        public venueContact: string,
        public venueContent: string,
        public venueName: string,
        public venueState: string,
        public venueZip: string,
        public profilePassword: string,
        public profilePasswordConfirm: string
    ) {}
}