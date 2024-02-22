import { TestBed } from '@angular/core/testing';

import { CompetitionRoomLinkService } from './competition-room-link.service';

describe('CompetitionRoomLinkService', () => {
  let service: CompetitionRoomLinkService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(CompetitionRoomLinkService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
