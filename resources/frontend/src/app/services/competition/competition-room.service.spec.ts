import { TestBed } from '@angular/core/testing';

import { CompetitionRoomService } from './competition-room.service';

describe('CompetitionRoomService', () => {
  let service: CompetitionRoomService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(CompetitionRoomService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
