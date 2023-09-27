import { TestBed } from '@angular/core/testing';

import { CompetitionGameService } from './competition-game.service';

describe('CompetitionGameService', () => {
  let service: CompetitionGameService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(CompetitionGameService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
