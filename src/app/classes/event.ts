export class Event {
	constructor(
		public eventId: number,
		public eventVenueId: number,
		public eventContact: string,
		public eventContent: string,
		public eventDateTime: string,
		public eventName: string
) {}
}