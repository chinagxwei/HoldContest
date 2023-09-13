import { TestBed } from '@angular/core/testing';

import { CompetitionGameTeamService } from './competition-game-team.service';

describe('CompetitionGameTeamService', () => {
  let service: CompetitionGameTeamService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(CompetitionGameTeamService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
